<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

class CouponController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
    }

    // GET /admin/coupons
    public function index()
    {
        $coupons = $this->db->find('coupons', []) ?: [];
        $this->renderAdmin('coupons/list', [
            'title'   => 'Coupons',
            'coupons' => $coupons,
        ]);
    }

    // GET /admin/coupons/create
    public function create()
    {
        $this->renderAdmin('coupons/create', ['title' => 'Create Coupon']);
    }

    // POST /admin/coupons/create
    public function store()
    {
        $code  = strtoupper(trim($_POST['code'] ?? ''));
        $type  = $_POST['type'] ?? 'percent';
        $value = (float)($_POST['value'] ?? 0);
        $limit = $_POST['usage_limit'] !== '' ? (int)$_POST['usage_limit'] : null;
        $expiry = !empty($_POST['expires_at']) ? $_POST['expires_at'] : null;

        if (!$code || $value <= 0) {
            $this->renderAdmin('coupons/create', [
                'title' => 'Create Coupon',
                'error' => 'Code and value are required.',
                'old'   => $_POST,
            ]);
            return;
        }

        // Check duplicate
        $existing = $this->db->findOne('coupons', ['code' => $code]);
        if ($existing) {
            $this->renderAdmin('coupons/create', [
                'title' => 'Create Coupon',
                'error' => 'A coupon with this code already exists.',
                'old'   => $_POST,
            ]);
            return;
        }

        $this->db->insert('coupons', [
            'id'          => uniqid('cpn_'),
            'code'        => $code,
            'type'        => $type,
            'value'       => $value,
            'usage_limit' => $limit,
            'used_count'  => 0,
            'expires_at'  => $expiry,
            'active'      => 1,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        header('Location: /admin/coupons');
        exit;
    }

    // GET /admin/coupons/delete?id=xxx
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->db->delete('coupons', $id);
        }
        header('Location: /admin/coupons');
        exit;
    }
}
