<?php
// Admin Entry Point
require_once __DIR__ . '/../core/Autoload.php';

use Core\Router;
use Admin\Controllers\DashboardController;
use Admin\Controllers\AuthController;

// Check Installation Lock globally
$isInstalled = file_exists(__DIR__ . '/../anicom-data/settings/installed.lock');
$uri = $_SERVER['REQUEST_URI'] ?? '/admin/';

// Natively redirect all admin traffic to setup if lock is missing
if (!$isInstalled && strpos($uri, '/admin/setup') !== 0) {
    header('Location: /admin/setup');
    exit;
}

// Boot admin router
$router = new Router();

$router->get('/admin/setup', [\Admin\Controllers\WizardController::class, 'index']);
$router->post('/admin/setup', [\Admin\Controllers\WizardController::class, 'process']);

$router->get('/admin/login', [AuthController::class, 'login']);
$router->post('/admin/login', [AuthController::class, 'login']);
$router->get('/admin/logout', [AuthController::class, 'logout']);

$router->get('/admin/products', [\Admin\Controllers\ProductController::class, 'index']);
$router->get('/admin/products/create', [\Admin\Controllers\ProductController::class, 'create']);
$router->post('/admin/products/create', [\Admin\Controllers\ProductController::class, 'create']);
$router->get('/admin/products/delete', [\Admin\Controllers\ProductController::class, 'delete']);

$router->get('/admin/categories', [\Admin\Controllers\CategoryController::class, 'index']);
$router->get('/admin/categories/create', [\Admin\Controllers\CategoryController::class, 'create']);
$router->post('/admin/categories/create', [\Admin\Controllers\CategoryController::class, 'create']);
$router->get('/admin/categories/delete', [\Admin\Controllers\CategoryController::class, 'delete']);

$router->get('/admin/orders', [\Admin\Controllers\OrderController::class, 'index']);
$router->get('/admin/orders/status', [\Admin\Controllers\OrderController::class, 'status']);

$router->get('/admin', [DashboardController::class, 'index']);
$router->get('/admin/', [DashboardController::class, 'index']);

// Dispatch
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/admin/';

$router->dispatch($uri, $method);
