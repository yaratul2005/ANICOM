<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

class CategoryController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
        if (Config::get('database.default') === 'mysql') {
            $this->db->query("CREATE TABLE IF NOT EXISTS `categories` (
                `id` VARCHAR(50) PRIMARY KEY,
                `title` VARCHAR(255),
                `slug` VARCHAR(255)
            )");
        }
    }

    public function index()
    {
        $categories = $this->db->find('categories');
        $this->renderAdmin('categories/list', ['title' => 'Categories', 'categories' => $categories]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->db->insert('categories', [
                'id' => uniqid('cat_'),
                'title' => $_POST['title'] ?? 'New Category',
                'slug' => strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $_POST['title']))
            ]);
            header('Location: /admin/categories');
            exit;
        }
        $this->renderAdmin('categories/form', ['title' => 'Add Category']);
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->db->delete('categories', $id);
        }
        header('Location: /admin/categories');
        exit;
    }
}
