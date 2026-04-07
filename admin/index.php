<?php
// Admin Entry Point
require_once __DIR__ . '/../core/Autoload.php';

use Core\Router;
use Core\Auth;
use Admin\Controllers\DashboardController;
use Admin\Controllers\AuthController;

// Start session to ensure globals hit Auth correctly
Auth::startSession();

// Check Installation Lock globally
$isInstalled = file_exists(__DIR__ . '/../anicom-data/settings/installed.lock');
$uri = strtok($_SERVER['REQUEST_URI'] ?? '/admin/', '?');

// Calculate stripped URI just like the router will, to apply accurate middleware filters
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$routePath = $uri;
if ($scriptDir !== '/' && $scriptDir !== '\\' && strpos($routePath, $scriptDir) === 0) {
    $routePath = substr($routePath, strlen($scriptDir));
}
$routePath = str_replace('/index.php', '', $routePath);
if ($routePath === '' || $routePath === false) $routePath = '/';

// Natively redirect all admin traffic to setup if lock is missing
if (!$isInstalled && $routePath !== '/setup') {
    header('Location: /admin/setup');
    exit;
}

// ==== GLOBAL ADMIN FIREWALL ====
// Protect the entire admin backend from a single entry point.
$publicAdminRoutes = ['/setup', '/login', '/logout'];
if (!in_array($routePath, $publicAdminRoutes)) {
    Auth::requireAdmin();
}

// Boot admin router
$router = new Router();

// Note: all routes are defined relative to the admin/ directory root 
// (e.g. `/setup` instead of `/admin/setup`) so they resolve correctly through Router's script-stripping.

$router->get('/setup', [\Admin\Controllers\WizardController::class, 'index']);
$router->post('/setup', [\Admin\Controllers\WizardController::class, 'process']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Products
$router->get('/products', [\Admin\Controllers\ProductController::class, 'index']);
$router->get('/products/create', [\Admin\Controllers\ProductController::class, 'create']);
$router->post('/products/create', [\Admin\Controllers\ProductController::class, 'create']);
$router->get('/products/delete', [\Admin\Controllers\ProductController::class, 'delete']);

// Categories
$router->get('/categories', [\Admin\Controllers\CategoryController::class, 'index']);
$router->get('/categories/create', [\Admin\Controllers\CategoryController::class, 'create']);
$router->post('/categories/create', [\Admin\Controllers\CategoryController::class, 'create']);
$router->get('/categories/delete', [\Admin\Controllers\CategoryController::class, 'delete']);

// Orders
$router->get('/orders', [\Admin\Controllers\OrderController::class, 'index']);
$router->get('/orders/status', [\Admin\Controllers\OrderController::class, 'status']);

// Coupons
$router->get('/coupons', [\Admin\Controllers\CouponController::class, 'index']);
$router->get('/coupons/create', [\Admin\Controllers\CouponController::class, 'create']);
$router->post('/coupons/create', [\Admin\Controllers\CouponController::class, 'store']);
$router->get('/coupons/delete', [\Admin\Controllers\CouponController::class, 'delete']);

// Pages
$router->get('/pages', [\Admin\Controllers\PageController::class, 'index']);
$router->get('/pages/create', [\Admin\Controllers\PageController::class, 'create']);
$router->post('/pages/create', [\Admin\Controllers\PageController::class, 'create']);
$router->get('/pages/delete', [\Admin\Controllers\PageController::class, 'delete']);

// Settings
$router->get('/settings', [\Admin\Controllers\SettingsController::class, 'index']);
$router->post('/settings', [\Admin\Controllers\SettingsController::class, 'save']);

// Dashboard
$router->get('/', [DashboardController::class, 'index']);
$router->get('', [DashboardController::class, 'index']);

// Dispatch
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$router->dispatch($uri, $method);
