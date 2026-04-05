<?php
// Storefront Entry Point
require_once __DIR__ . '/core/Autoload.php';

use Core\Router;
use Core\Controller;

// Simple inline Controller for Storefront testing
use Core\Controllers\StorefrontController;

// Boot Core Router
$router = new Router();

$router->get('/', [StorefrontController::class, 'home']);
$router->get('/product/{slug}', [StorefrontController::class, 'product']);
$router->get('/cart', [StorefrontController::class, 'cart']);
$router->post('/cart/add', [StorefrontController::class, 'addToCart']);
$router->get('/checkout', [StorefrontController::class, 'checkout']);
$router->post('/checkout', [StorefrontController::class, 'checkout']);

// Dispatch
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';

$router->dispatch($uri, $method);
