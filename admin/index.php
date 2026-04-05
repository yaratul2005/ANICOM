<?php
// Admin Entry Point
require_once __DIR__ . '/../core/Autoload.php';

use Core\Router;
use Admin\Controllers\DashboardController;
use Admin\Controllers\AuthController;

// Check Installation Lock globally
$isInstalled = file_exists(__DIR__ . '/../anicom-data/settings/installed.lock');
$uri = strtok($_SERVER['REQUEST_URI'] ?? '/admin/', '?');

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

// Products
$router->get('/admin/products', [\Admin\Controllers\ProductController::class, 'index']);
$router->get('/admin/products/create', [\Admin\Controllers\ProductController::class, 'create']);
$router->post('/admin/products/create', [\Admin\Controllers\ProductController::class, 'create']);
$router->get('/admin/products/delete', [\Admin\Controllers\ProductController::class, 'delete']);

// Categories
$router->get('/admin/categories', [\Admin\Controllers\CategoryController::class, 'index']);
$router->get('/admin/categories/create', [\Admin\Controllers\CategoryController::class, 'create']);
$router->post('/admin/categories/create', [\Admin\Controllers\CategoryController::class, 'create']);
$router->get('/admin/categories/delete', [\Admin\Controllers\CategoryController::class, 'delete']);

// Orders
$router->get('/admin/orders', [\Admin\Controllers\OrderController::class, 'index']);
$router->get('/admin/orders/status', [\Admin\Controllers\OrderController::class, 'status']);

// Coupons
$router->get('/admin/coupons', [\Admin\Controllers\CouponController::class, 'index']);
$router->get('/admin/coupons/create', [\Admin\Controllers\CouponController::class, 'create']);
$router->post('/admin/coupons/create', [\Admin\Controllers\CouponController::class, 'store']);
$router->get('/admin/coupons/delete', [\Admin\Controllers\CouponController::class, 'delete']);

// Settings
$router->get('/admin/settings', [\Admin\Controllers\SettingsController::class, 'index']);
$router->post('/admin/settings', [\Admin\Controllers\SettingsController::class, 'save']);

// Dashboard
$router->get('/admin', [DashboardController::class, 'index']);
$router->get('/admin/', [DashboardController::class, 'index']);

// Dispatch
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri    = strtok($_SERVER['REQUEST_URI'] ?? '/admin/', '?');

$router->dispatch($uri, $method);
