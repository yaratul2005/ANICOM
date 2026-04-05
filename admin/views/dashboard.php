<style>
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 2rem; }
    .stat-card { display: flex; flex-direction: column; gap: 0.4rem; position: relative; overflow: hidden; }
    .stat-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #6366f1, #c084fc);
    }
    .stat-val { font-size: 2.2rem; font-weight: 800; color: #0f172a; line-height: 1.1; }
    .stat-label { color: #64748b; font-weight: 600; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.8px; }
    .stat-sub { font-size: 0.82rem; color: #94a3b8; margin-top: 0.2rem; }
    .badge-pending { display: inline-block; background: #fef3c7; color: #92400e; font-size: 0.75rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 20px; }
    .badge-ok { display: inline-block; background: #dcfce7; color: #166534; font-size: 0.75rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 20px; }

    .dash-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
    @media (max-width: 900px) { .dash-grid { grid-template-columns: 1fr; } }

    .section-title { font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0 0 1.25rem 0; display: flex; align-items: center; gap: 0.5rem; }
    .section-title span { width: 8px; height: 8px; border-radius: 50%; background: #6366f1; display: inline-block; }

    /* Orders table */
    .orders-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
    .orders-table th { text-align: left; padding: 0.6rem 0.75rem; color: #64748b; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; }
    .orders-table td { padding: 0.75rem; border-bottom: 1px solid #f1f5f9; color: #1e293b; vertical-align: middle; }
    .orders-table tr:last-child td { border-bottom: none; }
    .orders-table tr:hover td { background: #f8fafc; }
    .status-badge { display: inline-block; padding: 0.2rem 0.65rem; border-radius: 20px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-shipped { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    /* Top products bar chart */
    .bar-row { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.85rem; }
    .bar-label { font-size: 0.82rem; color: #475569; font-weight: 500; width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex-shrink: 0; }
    .bar-track { flex: 1; background: #f1f5f9; border-radius: 4px; height: 8px; overflow: hidden; }
    .bar-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #6366f1, #c084fc); transition: width 0.8s ease; }
    .bar-count { font-size: 0.78rem; font-weight: 700; color: #6366f1; width: 28px; text-align: right; flex-shrink: 0; }

    .empty-state { text-align: center; padding: 2rem; color: #94a3b8; font-size: 0.9rem; }
    .empty-state svg { width: 40px; height: 40px; margin-bottom: 0.75rem; opacity: 0.4; }

    .quick-links { display: flex; flex-direction: column; gap: 0.5rem; }
    .quick-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 10px; text-decoration: none; color: #475569; background: #f8fafc; font-weight: 500; font-size: 0.9rem; transition: all 0.2s; border: 1px solid #e2e8f0; }
    .quick-link:hover { background: #ede9fe; color: #6366f1; border-color: #c4b5fd; transform: translateX(3px); }
    .quick-link-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; background: #ede9fe; }
</style>

<h2 class="page-title">Dashboard</h2>

<!-- Stats Row -->
<div class="stats-grid">
    <div class="card stat-card">
        <span class="stat-label">Total Revenue</span>
        <span class="stat-val">$<?= number_format($totalRevenue ?? 0, 2) ?></span>
        <span class="stat-sub"><?= $totalOrders ?? 0 ?> total orders</span>
    </div>
    <div class="card stat-card">
        <span class="stat-label">Pending Orders</span>
        <span class="stat-val"><?= $pendingOrders ?? 0 ?></span>
        <span class="stat-sub"><span class="badge-pending">Needs action</span></span>
    </div>
    <div class="card stat-card">
        <span class="stat-label">Products</span>
        <span class="stat-val"><?= $totalProducts ?? 0 ?></span>
        <span class="stat-sub">Published in store</span>
    </div>
    <div class="card stat-card">
        <span class="stat-label">Customers</span>
        <span class="stat-val"><?= $totalCustomers ?? 0 ?></span>
        <span class="stat-sub">Registered accounts</span>
    </div>
    <div class="card stat-card">
        <span class="stat-label">Active Coupons</span>
        <span class="stat-val"><?= $activeCoupons ?? 0 ?></span>
        <span class="stat-sub"><span class="badge-ok">Live</span></span>
    </div>
</div>

<!-- Main Grid -->
<div class="dash-grid">
    <!-- Recent Orders -->
    <div class="card">
        <div class="section-title"><span></span> Recent Orders</div>
        <?php if (!empty($recentOrders)): ?>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($recentOrders as $order): ?>
                <tr>
                    <td style="font-family: monospace; font-size: 0.8rem; color: #6366f1;"><?= htmlspecialchars(substr($order['id'], 0, 16)) ?>&hellip;</td>
                    <td><?= htmlspecialchars($order['customer_name'] ?? '—') ?></td>
                    <td><strong>$<?= number_format($order['total'] ?? 0, 2) ?></strong></td>
                    <td><span class="status-badge status-<?= htmlspecialchars($order['status'] ?? 'pending') ?>"><?= htmlspecialchars($order['status'] ?? 'pending') ?></span></td>
                    <td style="color: #94a3b8;"><?= htmlspecialchars(substr($order['created_at'] ?? '', 0, 10)) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p>No orders yet. They'll appear here once customers start buying.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Right Column -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Top Products -->
        <div class="card">
            <div class="section-title"><span></span> Top Products</div>
            <?php if (!empty($topProducts)):
                $maxSales = max($topProducts);
                foreach ($topProducts as $name => $qty):
                    $pct = $maxSales > 0 ? round(($qty / $maxSales) * 100) : 0;
            ?>
            <div class="bar-row">
                <span class="bar-label" title="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></span>
                <div class="bar-track"><div class="bar-fill" style="width: <?= $pct ?>%"></div></div>
                <span class="bar-count"><?= $qty ?></span>
            </div>
            <?php endforeach; else: ?>
            <div class="empty-state"><p>No sales data yet.</p></div>
            <?php endif; ?>
        </div>

        <!-- Quick Links -->
        <div class="card">
            <div class="section-title"><span></span> Quick Actions</div>
            <div class="quick-links">
                <a href="/admin/products/create" class="quick-link"><span class="quick-link-icon">📦</span> Add New Product</a>
                <a href="/admin/coupons/create" class="quick-link"><span class="quick-link-icon">🏷️</span> Create Coupon</a>
                <a href="/admin/orders" class="quick-link"><span class="quick-link-icon">🛒</span> View All Orders</a>
                <a href="/admin/settings" class="quick-link"><span class="quick-link-icon">⚙️</span> Store Settings</a>
            </div>
        </div>
    </div>
</div>
