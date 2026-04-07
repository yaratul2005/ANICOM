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
        $this->db = Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
        if (Config::get('database.default') === 'mysql') {
            $this->db->query("CREATE TABLE IF NOT EXISTS `products` (
                `id` VARCHAR(50) PRIMARY KEY,
                `title` VARCHAR(255),
                `slug` VARCHAR(255),
                `description` TEXT,
                `price` DECIMAL(10,2),
                `compare_at_price` DECIMAL(10,2),
                `image` VARCHAR(255),
                `media` TEXT,
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
                'slug' => strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $_POST['title'] ?? '')),
                'description' => $_POST['description'] ?? '',
                'price' => $_POST['price'] ?? 0.00,
                'compare_at_price' => $_POST['compare_at_price'] ?? 0.00,
                'status' => $_POST['status'] ?? 'draft'
            ];

            $mediaFiles = [];
            $uploadDir = __DIR__ . '/../../uploads/products/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            // Handle multiple media upload
            if (isset($_FILES['media']) && is_array($_FILES['media']['name'])) {
                $count = count($_FILES['media']['name']);
                for ($i = 0; $i < $count; $i++) {
                    if ($_FILES['media']['error'][$i] === UPLOAD_ERR_OK) {
                        $fileMock = [
                            'name' => $_FILES['media']['name'][$i],
                            'type' => $_FILES['media']['type'][$i],
                            'tmp_name' => $_FILES['media']['tmp_name'][$i],
                            'error' => $_FILES['media']['error'][$i],
                            'size' => $_FILES['media']['size'][$i]
                        ];
                        $imageName = ImageProcessor::process($fileMock, $uploadDir);
                        if ($imageName) $mediaFiles[] = $imageName;
                    }
                }
            }

            if (!empty($mediaFiles)) {
                $data['media'] = json_encode($mediaFiles);
                $data['image'] = $mediaFiles[0]; // backward compatibility
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
