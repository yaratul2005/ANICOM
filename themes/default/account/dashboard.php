<?php
use Core\Customer;
use Core\Config;
?>
<style>
    .account-grid { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; }
    @media (max-width: 768px) { .account-grid { grid-template-columns: 1fr; } }

    .account-sidebar { display: flex; flex-direction: column; gap: 1.25rem; }
    .profile-card { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border-radius: 20px; padding: 1.75rem; text-align: center; }
    .avatar { width: 72px; height: 72px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800; margin: 0 auto 1rem; border: 3px solid rgba(255,255,255,0.3); }
    .profile-name { font-size: 1.1rem; font-weight: 700; }
    .profile-email { font-size: 0.82rem; opacity: 0.8; margin-top: 0.3rem; word-break: break-all; }
    .profile-since { font-size: 0.75rem; opacity: 0.6; margin-top: 0.5rem; }

    .sidebar-nav { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; }
    .sidebar-nav a { display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; color: #475569; text-decoration: none; font-weight: 500; font-size: 0.9rem; border-bottom: 1px solid #f1f5f9; transition: all 0.2s; }
    .sidebar-nav a:last-child { border-bottom: none; }
    .sidebar-nav a.active, .sidebar-nav a:hover { background: #f5f3ff; color: #6366f1; }
    .sidebar-nav a.danger { color: #dc2626; }
    .sidebar-nav a.danger:hover { background: #fef2f2; }

    .section-heading { font-size: 1.2rem; font-weight: 700; color: #0f172a; margin: 0 0 1.25rem 0; display: flex; align-items: center; gap: 0.75rem; }
    .section-heading::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }

    .orders-list { display: flex; flex-direction: column; gap: 1rem; }
    .order-card { border: 1px solid #e2e8f0; border-radius: 14px; padding: 1.25rem 1.5rem; transition: all 0.2s; }
    .order-card:hover { border-color: #c4b5fd; box-shadow: 0 4px 12px rgba(99,102,241,0.1); }
    .order-meta { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.75rem; }
    .order-id { font-family: monospace; font-size: 0.82rem; color: #6366f1; font-weight: 700; }
    .order-total { font-size: 1.1rem; font-weight: 800; color: #0f172a; }
    .order-date { font-size: 0.8rem; color: #94a3b8; }
    .order-items-preview { font-size: 0.82rem; color: #64748b; background: #f8fafc; padding: 0.5rem 0.75rem; border-radius: 8px; }
    .status-badge { padding: 0.2rem 0.65rem; border-radius: 20px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-shipped { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    .no-orders { text-align: center; padding: 3rem 2rem; color: #94a3b8; }
    .no-orders a { color: #6366f1; font-weight: 600; text-decoration: none; }
</style>

<div class="account-grid">
    <!-- Sidebar -->
    <div class="account-sidebar">
        <div class="profile-card">
            <div class="avatar"><?= strtoupper(substr($customer['name'], 0, 1)) ?></div>
            <div class="profile-name"><?= htmlspecialchars($customer['name']) ?></div>
            <div class="profile-email"><?= htmlspecialchars($customer['email']) ?></div>
        </div>
        <div class="sidebar-nav">
            <a href="/account" class="active">🧾 My Orders</a>
            <a href="/">🏠 Continue Shopping</a>
            <a href="/account/logout" class="danger">🚪 Sign Out</a>
        </div>
    </div>

    <!-- Main Content -->
    <div>
        <div class="section-heading">Order History</div>

        <?php if (!empty($orders)): ?>
        <div class="orders-list">
        <?php foreach (array_reverse($orders) as $order):
            $items = json_decode($order['items'] ?? '[]', true) ?: [];
            $preview = implode(', ', array_map(fn($i) => $i['title'] ?? 'Item', array_slice($items, 0, 2)));
            if (count($items) > 2) $preview .= ' +' . (count($items) - 2) . ' more';
        ?>
            <div class="order-card">
                <div class="order-meta">
                    <div>
                        <div class="order-id">#<?= htmlspecialchars($order['id']) ?></div>
                        <div class="order-date"><?= htmlspecialchars(substr($order['created_at'] ?? '', 0, 10)) ?></div>
                    </div>
                    <div style="text-align: right;">
                        <div class="order-total">$<?= number_format($order['total'] ?? 0, 2) ?></div>
                        <span class="status-badge status-<?= htmlspecialchars($order['status'] ?? 'pending') ?>"><?= htmlspecialchars($order['status'] ?? 'pending') ?></span>
                    </div>
                </div>
                <?php if ($preview): ?>
                <div class="order-items-preview">📦 <?= htmlspecialchars($preview) ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="no-orders">
            <p style="font-size: 3rem;">🛍️</p>
            <p style="font-size: 1.1rem; font-weight: 600; margin: 0.75rem 0;">No orders yet!</p>
            <p style="margin-bottom: 1.5rem;">Start exploring our collection and place your first order.</p>
            <a href="/">Browse Products →</a>
        </div>
        <?php endif; ?>
    </div>
</div>
