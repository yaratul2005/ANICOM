<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

class PageController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
        if (Config::get('database.default') === 'mysql') {
            $this->db->query("CREATE TABLE IF NOT EXISTS `pages` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `slug` VARCHAR(255) NOT NULL UNIQUE,
                `title` VARCHAR(255) NOT NULL,
                `content` TEXT,
                `meta_desc` VARCHAR(500),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        }
    }

    public function index()
    {
        $pages = $this->db->find('pages', []) ?: [];
        $this->renderAdmin('pages/list', [
            'title' => 'Manage Pages',
            'pages' => $pages
        ]);
    }

    public function create()
    {
        $id = $_GET['id'] ?? null;
        $page = null;
        if ($id) {
            $page = $this->db->findOne('pages', ['id' => $id]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'slug' => trim(strtolower(preg_replace('/[^a-zA-Z0-9-]/', '-', $_POST['slug'] ?? $_POST['title']))),
                'content' => $_POST['content'] ?? '',
                'meta_desc' => trim($_POST['meta_desc'] ?? ''),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($id) {
                $this->db->update('pages', $id, $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('pages', $data);
            }

            header('Location: /admin/pages');
            exit;
        }

        $this->renderAdmin('pages/create', [
            'title' => $id ? 'Edit Page' : 'Create Page',
            'page'  => $page
        ]);
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $this->db->delete('pages', $_GET['id']);
        }
        header('Location: /admin/pages');
        exit;
    }
}
