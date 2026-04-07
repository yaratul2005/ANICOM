<style>
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem; }
    
    .stat-card {
        background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px;
        padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem;
        transition: all 0.3s; position: relative; overflow: hidden;
    }
    .stat-card::after { content: ''; position: absolute; inset: 3px; border: var(--stitch-border); border-radius: 17px; pointer-events: none; opacity: 0.15; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-glow); border-color: var(--m-purple); }
    
    .stat-icon {
        width: 54px; height: 54px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; position: relative;
    }
    .stat-icon svg { width: 26px; height: 26px; stroke: #fff; fill: none; stroke-width: 2; }
    .stat-icon.rev { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 0 15px rgba(16,185,129,0.3); }
    .stat-icon.ord { background: linear-gradient(135deg, var(--m-blue), #2563eb); box-shadow: 0 0 15px rgba(59,130,246,0.3); }
    .stat-icon.cus { background: var(--gradient-magic); box-shadow: var(--shadow-glow); }
    .stat-icon.pro { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 0 15px rgba(245,158,11,0.3); }

    .stat-info { display: flex; flex-direction: column; gap: 0.2rem; position: relative; z-index: 2; }
    .stat-label { font-size: 0.8rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 1px; }
    .stat-val { font-size: 1.6rem; font-weight: 900; color: #fff; }

    /* Layout for tables/charts */
    .dashboard-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; }
    @media (max-width: 1024px) { .dashboard-layout { grid-template-columns: 1fr; } }
    
    .panel { background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px; padding: 1.5rem; position: relative; }
    .panel::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 16px; pointer-events: none; opacity: 0.1; }
    .panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; position: relative; z-index: 2; }
    .panel-title { font-size: 1.1rem; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 0.5rem; }
    .panel-title svg { stroke: var(--m-cyan); width: 20px; height: 20px; }

    /* Orders Table */
    .table-responsive { overflow-x: auto; position: relative; z-index: 2; }
    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 0.8rem 1rem; font-size: 0.75rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px dashed rgba(255,255,255,0.05); }
    td { padding: 1rem; border-bottom: 1px dashed rgba(255,255,255,0.05); color: var(--m-text); font-size: 0.9rem; font-weight: 500; }
    tr:hover td { background: rgba(255,255,255,0.02); }
    
    .badge { display: inline-block; padding: 0.3rem 0.6rem; border-radius: 10px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
    .bg-green { background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }
    .bg-yellow { background: rgba(245,158,11,0.1); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); }
    
    /* Cosmic Bar Chart */
    .chart-container { display: flex; flex-direction: column; gap: 1rem; position: relative; z-index: 2; }
    .chart-row { display: flex; align-items: center; gap: 1rem; }
    .chart-label { width: 80px; font-size: 0.8rem; font-weight: 600; color: var(--m-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .chart-bar-wrap { flex: 1; min-width: 0; background: rgba(0,0,0,0.3); height: 12px; border-radius: 10px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); }
    .chart-bar { height: 100%; border-radius: 10px; transition: width 1s ease-out; box-shadow: inset 0 0 5px rgba(255,255,255,0.5); }
    .chart-value { width: 40px; text-align: right; font-size: 0.85rem; font-weight: 800; color: #fff; }
</style>

<div class="top-bar">
    <div class="page-title">
        <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        Command Center
    </div>
    <div class="top-actions">
        <a href="/admin/products/create" class="btn-primary">
            <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Forge Artifact
        </a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon rev"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></div>
        <div class="stat-info">
            <span class="stat-label">Cosmic Gold</span>
            <span class="stat-val">$<?= number_format($stats['revenue'], 2) ?></span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon ord"><svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></div>
        <div class="stat-info">
            <span class="stat-label">Orders</span>
            <span class="stat-val"><?= number_format($stats['orders']) ?></span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon cus"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div>
        <div class="stat-info">
            <span class="stat-label">Entities</span>
            <span class="stat-val"><?= number_format($stats['customers']) ?></span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon pro"><svg viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg></div>
        <div class="stat-info">
            <span class="stat-label">Artifacts</span>
            <span class="stat-val"><?= number_format($stats['products']) ?></span>
        </div>
    </div>
</div>

<div class="dashboard-layout">
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg> Recent Transmissions</div>
            <a href="/admin/orders" class="btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">View All</a>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Entity</th>
                        <th>Chronology</th>
                        <th>Status</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_orders)): ?>
                        <?php foreach($recent_orders as $order): ?>
                        <tr>
                            <td style="font-family:monospace; color:var(--m-cyan);">#<?= htmlspecialchars($order['id']) ?></td>
                            <td style="font-weight:700; color:#fff;"><?= htmlspecialchars($order['customer_name'] ?? 'Guest') ?></td>
                            <td style="color:var(--m-muted); font-size:0.8rem;"><?= htmlspecialchars(substr($order['created_at'], 0, 10)) ?></td>
                            <td><span class="badge <?= $order['status'] === 'completed' ? 'bg-green' : 'bg-yellow' ?>"><?= htmlspecialchars($order['status']) ?></span></td>
                            <td style="font-weight:800;">$<?= number_format($order['total'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center; padding: 3rem; color:var(--m-muted);">No transmissions detected.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg> Top Artifacts</div>
        </div>
        
        <div class="chart-container">
            <?php 
            $maxQty = !empty($top_products) ? max(array_column($top_products, 'total_qty')) : 1;
            if (!empty($top_products)): 
                $colors = ['linear-gradient(90deg, #3b82f6, #06b6d4)', 'linear-gradient(90deg, #8b5cf6, #d946ef)', 'linear-gradient(90deg, #f59e0b, #fbbf24)', 'linear-gradient(90deg, #10b981, #34d399)', 'linear-gradient(90deg, #ec4899, #f43f5e)'];
                foreach ($top_products as $idx => $tp):
                    $pct = ($tp['total_qty'] / $maxQty) * 100;
                    $bg = $colors[$idx % count($colors)];
            ?>
            <div class="chart-row">
                <div class="chart-label" title="<?= htmlspecialchars($tp['title']) ?>"><?= htmlspecialchars($tp['title']) ?></div>
                <div class="chart-bar-wrap">
                    <div class="chart-bar" style="width: <?= $pct ?>%; background: <?= $bg ?>;"></div>
                </div>
                <div class="chart-value"><?= (int)$tp['total_qty'] ?></div>
            </div>
            <?php endforeach; else: ?>
                <div style="text-align:center; color:var(--m-muted); padding:2rem 0;">Awaiting artifact data.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
