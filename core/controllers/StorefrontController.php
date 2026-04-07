<?php
namespace Core\Controllers;

use Core\Controller;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;
use Core\Cart;
use Core\Coupon;
use Core\Mailer;

class StorefrontController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function home()
    {
        $products   = $this->db->find('products', ['status' => 'published']);
        $categories = $this->db->find('categories', []) ?: [];
        $this->render('home', [
            'title'      => Config::get('app.name') . ' | Home',
            'products'   => $products,
            'categories' => $categories,
        ]);
    }

    public function page($slug)
    {
        $page = $this->db->findOne('pages', ['slug' => $slug]);
        if (!$page) {
            header("HTTP/1.0 404 Not Found");
            echo "404 Page Not Found";
            exit;
        }

        $this->render('page', [
            'title' => $page['title'] . ' | ' . Config::get('app.name'),
            'meta_desc' => $page['meta_desc'],
            'page' => $page
        ]);
    }

    public function product($slug)
    {
        $product = $this->db->findOne('products', ['slug' => $slug, 'status' => 'published']);
        if (!$product) {
            header("HTTP/1.0 404 Not Found");
            echo "Product not found";
            exit;
        }

        // Related products (same category, exclude self)
        $related = [];
        if (!empty($product['category_id'])) {
            $all     = $this->db->find('products', ['status' => 'published', 'category_id' => $product['category_id']]) ?: [];
            $related = array_filter($all, fn($p) => $p['id'] !== $product['id']);
            $related = array_slice(array_values($related), 0, 4);
        }

        $this->render('product', [
            'title'   => $product['title'] . ' | ' . Config::get('app.name'),
            'product' => $product,
            'related' => $related,
        ]);
    }

    public function cart()
    {
        $items   = Cart::getItems();
        $subtotal = Cart::getTotal();
        $coupon  = Coupon::getSessionCoupon();
        $discount = $coupon ? Coupon::calculateDiscount($coupon, $subtotal) : 0;
        $total   = max(0, $subtotal - $discount);

        $this->render('cart', [
            'title'    => 'Shopping Cart',
            'items'    => $items,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'coupon'   => $coupon,
            'total'    => $total,
        ]);
    }

    public function addToCart()
    {
        $id  = $_POST['product_id'] ?? null;
        $qty = (int)($_POST['quantity'] ?? 1);

        if ($id) {
            $product = $this->db->findOne('products', ['id' => $id]);
            if ($product) {
                Cart::add($product, $qty);
            }
        }
        header('Location: /cart');
        exit;
    }

    public function applyCoupon()
    {
        $code = trim($_POST['coupon_code'] ?? '');
        [$discount, $error] = Coupon::applyToSession($code);

        if ($error) {
            $_SESSION['coupon_error'] = $error;
        } else {
            $_SESSION['coupon_success'] = 'Coupon applied! You saved $' . number_format($discount, 2) . '.';
        }

        header('Location: /cart');
        exit;
    }

    public function removeCoupon()
    {
        Coupon::removeFromSession();
        header('Location: /cart');
        exit;
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subtotal = Cart::getTotal();
            $coupon   = Coupon::getSessionCoupon();
            $discount = $coupon ? Coupon::calculateDiscount($coupon, $subtotal) : 0;
            $total    = max(0, $subtotal - $discount);

            $orderData = [
                'id'             => uniqid('ord_'),
                'customer_name'  => $_POST['name'] ?? '',
                'customer_address'=> $_POST['address'] ?? '',
                'customer_phone' => $_POST['phone'] ?? '',
                'total'          => $total,
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'coupon_code'    => $coupon['code'] ?? null,
                'items'          => json_encode(Cart::getItems()),
                'status'         => 'pending_verification',
                'created_at'     => date('Y-m-d H:i:s'),
            ];

            if (Config::get('database.default') === 'mysql') {
                $this->db->query("CREATE TABLE IF NOT EXISTS `orders` (
                    `id` VARCHAR(50) PRIMARY KEY,
                    `customer_name` VARCHAR(255),
                    `customer_address` TEXT,
                    `customer_phone` VARCHAR(50),
                    `total` DECIMAL(10,2),
                    `subtotal` DECIMAL(10,2),
                    `discount` DECIMAL(10,2),
                    `coupon_code` VARCHAR(50),
                    `items` TEXT,
                    `status` VARCHAR(50),
                    `created_at` DATETIME
                )");
            }

            $this->db->insert('orders', $orderData);

            // Redeem coupon usage count
            if ($coupon) {
                Coupon::redeem($coupon['code']);
                Coupon::removeFromSession();
            }

            // Email logic removed for purely COD-based physical checkout funnel

            Cart::clear();

            $this->render('checkout_success', [
                'title' => 'Order Complete',
                'order' => $orderData,
            ]);
            exit;
        }

        $items    = Cart::getItems();
        $subtotal = Cart::getTotal();
        $coupon   = Coupon::getSessionCoupon();
        $discount = $coupon ? Coupon::calculateDiscount($coupon, $subtotal) : 0;
        $total    = max(0, $subtotal - $discount);

        $this->render('checkout', [
            'title'    => 'Checkout',
            'items'    => $items,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'coupon'   => $coupon,
            'total'    => $total,
        ]);
    }
}
