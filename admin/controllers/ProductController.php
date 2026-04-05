<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;
use Core\Helpers\ImageProcessor;

class ProductController extends Controller
{
    private $db;

    public function __construct()
    {
        Auth::requireAdmin();
        $this->db = Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
        if (Config::get('database.default') === 'mysql') {
            // Hot-init table natively
            $this->db->query("CREATE TABLE IF NOT EXISTS `products` (
                `id` VARCHAR(50) PRIMARY KEY,
                `title` VARCHAR(255),
                `slug` VARCHAR(255),
                `price` DECIMAL(10,2),
                `image` VARCHAR(255),
                `status` VARCHAR(20) DEFAULT 'published'
            )");
        }
    }

    public function index()
    {
        $products = $this->db->find('products');
        $this->renderAdmin('products/list', ['title' => 'Products', 'products' => $products]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => uniqid('p_'),
                'title' => $_POST['title'] ?? 'Draft Product',
                'slug' => strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $_POST['title'])),
                'price' => $_POST['price'] ?? 0.00,
                'status' => $_POST['status'] ?? 'draft'
            ];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../uploads/products/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                $imageName = ImageProcessor::process($_FILES['image'], $uploadDir);
                if ($imageName) $data['image'] = $imageName;
            }

            $this->db->insert('products', $data);
            header('Location: /admin/products');
            exit;
        }

        $this->renderAdmin('products/form', ['title' => 'Add Product']);
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->db->delete('products', $id);
        }
        header('Location: /admin/products');
        exit;
    }
}
