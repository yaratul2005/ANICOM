<?php
namespace Core\Controllers;

use Core\Controller;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;
use Core\Cart;

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
        $products = $this->db->find('products', ['status' => 'published']);
        $this->render('home', [
            'title' => Config::get('app.name') . ' | Home',
            'products' => $products
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

        $this->render('product', [
            'title' => $product['title'] . ' | ' . Config::get('app.name'),
            'product' => $product
        ]);
    }

    public function cart()
    {
        $items = Cart::getItems();
        $total = Cart::getTotal();
        $this->render('cart', [
            'title' => 'Shopping Cart',
            'items' => $items,
            'total' => $total
        ]);
    }

    public function addToCart()
    {
        $id = $_POST['product_id'] ?? null;
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

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderData = [
                'id' => uniqid('ord_'),
                'customer_name' => $_POST['name'] ?? '',
                'customer_email' => $_POST['email'] ?? '',
                'total' => Cart::getTotal(),
                'items' => json_encode(Cart::getItems()),
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Order creation natively supports dynamic table initialization
            if (Config::get('database.default') === 'mysql') {
                $this->db->query("CREATE TABLE IF NOT EXISTS `orders` (
                    `id` VARCHAR(50) PRIMARY KEY,
                    `customer_name` VARCHAR(255),
                    `customer_email` VARCHAR(255),
                    `total` DECIMAL(10,2),
                    `items` TEXT,
                    `status` VARCHAR(50),
                    `created_at` DATETIME
                )");
            }

            $this->db->insert('orders', $orderData);
            
            // Attempt core email delivery natively
            $mailContent = "Your order <strong>{$orderData['id']}</strong> for <strong>$" . number_format($orderData['total'], 2) . "</strong> has been received.<br>You will be notified once it ships.";
            \Core\Mailer::send($orderData['customer_email'], 'Order Confirmation - ' . Config::get('app.name'), $mailContent);
            
            // Clear Cart
            Cart::clear();

            // Simple render success
            $this->render('checkout_success', ['title' => 'Order Complete']);
            exit;
        }

        $this->render('checkout', [
            'title' => 'Checkout',
            'items' => Cart::getItems(),
            'total' => Cart::getTotal()
        ]);
    }
}
