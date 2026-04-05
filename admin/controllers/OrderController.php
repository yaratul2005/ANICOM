<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

class OrderController extends Controller
{
    private $db;

    public function __construct()
    {
        Auth::requireAdmin();
        $this->db = Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
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
    }

    public function index()
    {
        $orders = $this->db->find('orders', [], ['order_by' => 'created_at', 'order_dir' => 'DESC']);
        $this->renderAdmin('orders/list', ['title' => 'Orders', 'orders' => $orders]);
    }

    public function status()
    {
        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? 'pending';
        
        if ($id) {
            $this->db->update('orders', $id, ['status' => $status]);
        }
        
        header('Location: /admin/orders');
        exit;
    }
}
