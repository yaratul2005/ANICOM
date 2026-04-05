<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

class DashboardController extends Controller
{
    private $db;

    public function __construct()
    {
        Auth::requireAdmin();
        $this->db = Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
    }

    public function index()
    {
        // --- Live Analytics ---
        $orders    = $this->db->find('orders', []) ?: [];
        $products  = $this->db->find('products', []) ?: [];
        $customers = $this->db->find('customers', []) ?: [];
        $coupons   = $this->db->find('coupons', []) ?: [];

        $totalRevenue  = array_sum(array_column($orders, 'total'));
        $totalOrders   = count($orders);
        $pendingOrders = count(array_filter($orders, fn($o) => ($o['status'] ?? '') === 'pending'));
        $totalProducts = count($products);
        $totalCustomers = count($customers);

        // Top 5 products by appearance in orders
        $salesMap = [];
        foreach ($orders as $order) {
            $items = json_decode($order['items'] ?? '[]', true) ?: [];
            foreach ($items as $item) {
                $key = $item['title'] ?? ($item['id'] ?? 'Unknown');
                $salesMap[$key] = ($salesMap[$key] ?? 0) + (int)($item['quantity'] ?? 1);
            }
        }
        arsort($salesMap);
        $topProducts = array_slice($salesMap, 0, 5, true);

        // Recent 5 orders
        usort($orders, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        $recentOrders = array_slice($orders, 0, 5);

        $this->renderAdmin('dashboard', [
            'title'          => 'ANICOM | Dashboard',
            'totalRevenue'   => $totalRevenue,
            'totalOrders'    => $totalOrders,
            'pendingOrders'  => $pendingOrders,
            'totalProducts'  => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'topProducts'    => $topProducts,
            'recentOrders'   => $recentOrders,
            'activeCoupons'  => count(array_filter($coupons, fn($c) => ($c['active'] ?? 0) == 1)),
        ]);
    }
}
