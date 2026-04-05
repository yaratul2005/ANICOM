<?php
// Storefront Entry Point
require_once __DIR__ . '/core/Autoload.php';

use Core\Router;
use Core\Controllers\StorefrontController;
use Core\Controllers\AccountController;

// Boot Hooks & Plugins
require_once __DIR__ . '/core/helpers/plugin.php';
require_once __DIR__ . '/core/helpers/formatting.php';
require_once __DIR__ . '/core/helpers/translate.php';

// Auto-load active plugins
$pluginsDir = __DIR__ . '/plugins/';
if (is_dir($pluginsDir)) {
    foreach (scandir($pluginsDir) as $pluginFolder) {
        $pluginFile = $pluginsDir . $pluginFolder . '/plugin.php';
        if (file_exists($pluginFile)) {
            require_once $pluginFile;
        }
    }
}

// Boot Core Router
$router = new Router();

// --- Storefront Routes ---
$router->get('/', [StorefrontController::class, 'home']);
$router->get('/product/{slug}', [StorefrontController::class, 'product']);
$router->get('/cart', [StorefrontController::class, 'cart']);
$router->post('/cart/add', [StorefrontController::class, 'addToCart']);
$router->post('/cart/coupon/apply', [StorefrontController::class, 'applyCoupon']);
$router->get('/cart/coupon/remove', [StorefrontController::class, 'removeCoupon']);
$router->get('/checkout', [StorefrontController::class, 'checkout']);
$router->post('/checkout', [StorefrontController::class, 'checkout']);

// --- Account Routes ---
$router->get('/account/login', [AccountController::class, 'loginForm']);
$router->post('/account/login', [AccountController::class, 'loginSubmit']);
$router->get('/account/register', [AccountController::class, 'registerForm']);
$router->post('/account/register', [AccountController::class, 'registerSubmit']);
$router->get('/account', [AccountController::class, 'dashboard']);
$router->get('/account/logout', [AccountController::class, 'logout']);

// Dispatch
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri    = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');

$router->dispatch($uri, $method);
