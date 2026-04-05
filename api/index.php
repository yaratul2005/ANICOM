<?php
/**
 * ANICOM REST API Entry Point
 * Lightweight JSON API — headless / mobile ready
 * Authentication: Pass X-Api-Key header matching API_KEY in .env
 */
require_once __DIR__ . '/../core/Autoload.php';

use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

// --- JSON response helpers ---
function api_response(int $status, $data): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: X-Api-Key, Content-Type');
    echo json_encode(['status' => $status, 'data' => $data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function api_error(int $status, string $message): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => $status, 'error' => $message]);
    exit;
}

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: X-Api-Key, Content-Type');
    exit;
}

// --- API Key Auth ---
$apiKey = Config::get('app.api_key', '');
if (!empty($apiKey)) {
    $provided = $_SERVER['HTTP_X_API_KEY'] ?? '';
    if ($provided !== $apiKey) {
        api_error(401, 'Invalid or missing API key. Pass X-Api-Key header.');
    }
}

// --- DB ---
$db = Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();

// --- Router ---
$method = $_SERVER['REQUEST_METHOD'];
$uri    = strtok($_SERVER['REQUEST_URI'] ?? '/api', '?');
$uri    = preg_replace('#^/api#', '', $uri);

// Remove trailing slash
$uri = rtrim($uri, '/') ?: '/';

// GET /products
if ($method === 'GET' && $uri === '/products') {
    $products = $db->find('products', ['status' => 'published']) ?: [];
    // Strip internal fields
    $products = array_map(fn($p) => array_diff_key($p, ['__file' => 1]), $products);
    api_response(200, $products);
}

// GET /products/{id}
if ($method === 'GET' && preg_match('#^/products/(.+)$#', $uri, $m)) {
    $product = $db->findOne('products', ['id' => $m[1]]);
    if (!$product) api_error(404, 'Product not found.');
    api_response(200, $product);
}

// GET /categories
if ($method === 'GET' && $uri === '/categories') {
    $categories = $db->find('categories', []) ?: [];
    api_response(200, $categories);
}

// POST /orders — Create order via API (headless checkout)
if ($method === 'POST' && $uri === '/orders') {
    $body = json_decode(file_get_contents('php://input'), true);
    if (!$body) api_error(400, 'Invalid JSON body.');

    $required = ['customer_name', 'customer_email', 'items'];
    foreach ($required as $field) {
        if (empty($body[$field])) api_error(422, "Field '{$field}' is required.");
    }

    if (!filter_var($body['customer_email'], FILTER_VALIDATE_EMAIL)) {
        api_error(422, 'Invalid customer email address.');
    }

    $items = is_array($body['items']) ? $body['items'] : [];
    $total = array_sum(array_map(fn($i) => ($i['price'] ?? 0) * ($i['quantity'] ?? 1), $items));

    $order = [
        'id'             => uniqid('api_ord_'),
        'customer_name'  => $body['customer_name'],
        'customer_email' => $body['customer_email'],
        'total'          => $total,
        'subtotal'       => $total,
        'discount'       => 0,
        'coupon_code'    => null,
        'items'          => json_encode($items),
        'status'         => 'pending',
        'source'         => 'api',
        'created_at'     => date('Y-m-d H:i:s'),
    ];

    $db->insert('orders', $order);
    api_response(201, ['message' => 'Order created.', 'order_id' => $order['id']]);
}

// GET /ping — Health check (no auth required override)
if ($uri === '/ping') {
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(['status' => 200, 'message' => 'ANICOM API is online.', 'version' => '1.0.0', 'time' => date('c')]);
    exit;
}

// 404 fallback
api_error(404, 'API endpoint not found. Available: GET /products, GET /products/{id}, GET /categories, POST /orders, GET /ping');
