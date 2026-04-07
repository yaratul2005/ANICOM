<?php
use Core\Customer;
use Core\Config;
?>
<style>
    .account-grid { display: grid; grid-template-columns: 280px 1fr; gap: 3rem; }
    @media (max-width: 900px) { .account-grid { grid-template-columns: 1fr; gap: 2rem; } }

    .account-sidebar { display: flex; flex-direction: column; gap: 1.5rem; }
    .profile-card { 
        background: var(--m-card); 
        backdrop-filter: blur(12px);
        border: 1px solid var(--m-border); 
        border-radius: 24px; padding: 2rem; text-align: center; 
        position: relative; overflow: hidden;
    }
    .profile-card::after {
        content: ''; position: absolute; inset: 4px;
        border: var(--stitch-border);
        border-radius: 20px; pointer-events: none; opacity: 0.3;
    }
    .avatar { 
        width: 80px; height: 80px; border-radius: 50%; 
        background: var(--gradient-magic); 
        display: flex; align-items: center; justify-content: center; 
        font-size: 2rem; font-weight: 900; margin: 0 auto 1.25rem; 
        border: 2px dashed rgba(255,255,255,0.8); 
        color: #fff; box-shadow: var(--shadow-glow);
        animation: stitch-glow 2s infinite alternate;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .profile-name { font-size: 1.2rem; font-weight: 900; color: #fff; text-shadow: 0 0 10px rgba(255,255,255,0.2); margin-bottom: 0.2rem; }
    .profile-email { font-size: 0.85rem; color: var(--m-cyan); word-break: break-all; opacity: 0.9; }

    .sidebar-nav { background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px; overflow: hidden; position: relative; }
    .sidebar-nav::after { content: ''; position: absolute; inset: 3px; border: var(--stitch-border); border-radius: 16px; pointer-events: none; opacity: 0.15; }
    .sidebar-nav a { 
        display: flex; align-items: center; gap: 0.75rem; padding: 1.1rem 1.5rem; 
        color: var(--m-muted); text-decoration: none; font-weight: 600; font-size: 0.95rem; 
        border-bottom: 1px dashed rgba(255,255,255,0.05); transition: all 0.3s; position: relative; z-index: 2;
    }
    .sidebar-nav a svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; }
    .sidebar-nav a:last-child { border-bottom: none; }
    .sidebar-nav a.active, .sidebar-nav a:hover { background: rgba(139,92,246,0.1); color: var(--m-cyan); padding-left: 2rem; }
    .sidebar-nav a.danger { color: #f43f5e; }
    .sidebar-nav a.danger:hover { background: rgba(244,63,94,0.1); }

    .section-heading { font-size: 1.5rem; font-weight: 900; color: #fff; margin: 0 0 2rem 0; display: flex; align-items: center; gap: 0.75rem; }
    .section-heading::after { content: ''; flex: 1; height: 1px; background: var(--gradient-magic); opacity: 0.5; }
    .section-heading svg { width: 24px; height: 24px; stroke: var(--m-pink); fill: none; stroke-width: 2.5; stroke-linecap: round; }

    .orders-list { display: flex; flex-direction: column; gap: 1.25rem; }
    .order-card { 
        background: var(--m-card); border: 1px solid var(--m-border); 
        border-radius: 20px; padding: 1.5rem 2rem; transition: all 0.3s; 
        position: relative;
    }
    .order-card:hover { border-color: var(--m-purple); box-shadow: var(--shadow-magic); transform: translateX(5px); }
    .order-card::before { content: ''; position: absolute; left: 0; top: 1.5rem; bottom: 1.5rem; width: 3px; background: var(--gradient-magic); border-radius: 3px; opacity: 0; transition: opacity 0.3s; }
    .order-card:hover::before { opacity: 1; }
    
    .order-meta { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1rem; }
    .order-id { font-family: monospace; font-size: 0.9rem; color: var(--m-cyan); font-weight: 800; letter-spacing: 1px; }
    .order-total { font-size: 1.25rem; font-weight: 900; color: #fff; }
    .order-date { font-size: 0.85rem; color: var(--m-muted); font-weight: 500; }
    
    .order-items-preview { font-size: 0.85rem; color: var(--m-text); background: rgba(0,0,0,0.3); padding: 0.75rem 1rem; border-radius: 12px; border: 1px dashed rgba(255,255,255,0.1); display: flex; align-items: center; gap: 0.5rem; }
    .order-items-preview svg { width: 14px; height: 14px; stroke: var(--m-muted); fill: none; stroke-width: 2; }
    
    .status-badge { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border: 1px solid transparent; }
    .status-pending { background: rgba(245,158,11,0.1); border-color: rgba(245,158,11,0.3); color: #fbbf24; }
    .status-shipped { background: rgba(59,130,246,0.1); border-color: rgba(59,130,246,0.3); color: #60a5fa; }
    .status-completed { background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.3); color: #34d399; }
    .status-cancelled { background: rgba(244,63,94,0.1); border-color: rgba(244,63,94,0.3); color: #fb7185; }

    .no-orders { text-align: center; padding: 5rem 2rem; color: var(--m-muted); background: var(--m-card); border-radius: 24px; border: var(--stitch-border); }
    .no-orders a { display: inline-block; margin-top: 1rem; padding: 0.8rem 2rem; background: rgba(255,255,255,0.05); color: var(--m-cyan); font-weight: 800; border-radius: 20px; text-decoration: none; border: 1px solid var(--m-cyan); transition: all 0.3s; }
    .no-orders a:hover { background: var(--m-cyan); color: #000; box-shadow: 0 0 15px rgba(6,182,212,0.4); }
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
            <a href="/account" class="active">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                Quest Log (Orders)
            </a>
            <a href="/">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Return to Cosmos
            </a>
            <a href="/account/logout" class="danger">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Sever Connection
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div>
        <div class="section-heading">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Chronicles
        </div>

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
                <div class="order-items-preview">
                    <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    <?= htmlspecialchars($preview) ?>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="no-orders">
            <svg style="width:64px;height:64px;stroke:var(--m-border);fill:none;stroke-width:1;margin-bottom:1rem;" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
            <p style="font-size: 1.2rem; font-weight: 800; color:#fff;">No chronicles recorded.</p>
            <p>Your journey begins with your first acquisition.</p>
            <a href="/">Explore Artifacts</a>
        </div>
        <?php endif; ?>
    </div>
</div>
