<style>
    .coupon-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .btn-primary { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.35); }

    .coupons-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
    .coupons-table th { text-align: left; padding: 0.65rem 1rem; color: #64748b; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; }
    .coupons-table td { padding: 1rem; border-bottom: 1px solid #f1f5f9; color: #1e293b; vertical-align: middle; }
    .coupons-table tr:last-child td { border-bottom: none; }
    .coupons-table tr:hover td { background: #f8fafc; }

    .code-chip { font-family: monospace; font-size: 0.9rem; font-weight: 700; background: #ede9fe; color: #6366f1; padding: 0.25rem 0.75rem; border-radius: 6px; letter-spacing: 1px; display: inline-block; }
    .type-badge { display: inline-block; padding: 0.2rem 0.65rem; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
    .type-percent { background: #dbeafe; color: #1e40af; }
    .type-fixed { background: #fef3c7; color: #92400e; }
    .active-yes { color: #16a34a; font-weight: 700; }
    .active-no { color: #dc2626; font-weight: 700; }

    .btn-danger { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.35rem 0.9rem; background: #fee2e2; color: #dc2626; border-radius: 8px; text-decoration: none; font-size: 0.82rem; font-weight: 600; transition: background 0.2s; }
    .btn-danger:hover { background: #fecaca; }

    .empty-state { text-align: center; padding: 3rem; color: #94a3b8; }
</style>

<div class="coupon-header">
    <h2 class="page-title" style="margin: 0;">Coupons</h2>
    <a href="/admin/coupons/create" class="btn-primary">＋ Create Coupon</a>
</div>

<div class="card">
    <?php if (!empty($coupons)): ?>
    <table class="coupons-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Used / Limit</th>
                <th>Expires</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($coupons as $c): ?>
            <tr>
                <td><span class="code-chip"><?= htmlspecialchars($c['code']) ?></span></td>
                <td><span class="type-badge type-<?= $c['type'] ?>"><?= ucfirst($c['type']) ?></span></td>
                <td>
                    <?php if ($c['type'] === 'percent'): ?>
                        <strong><?= number_format($c['value'], 0) ?>%</strong> off
                    <?php else: ?>
                        <strong>$<?= number_format($c['value'], 2) ?></strong> off
                    <?php endif; ?>
                </td>
                <td><?= (int)($c['used_count'] ?? 0) ?> / <?= $c['usage_limit'] ?? '∞' ?></td>
                <td><?= $c['expires_at'] ? htmlspecialchars(substr($c['expires_at'], 0, 10)) : '<span style="color:#94a3b8;">Never</span>' ?></td>
                <td><?= $c['active'] ? '<span class="active-yes">✓ Yes</span>' : '<span class="active-no">✗ No</span>' ?></td>
                <td><a href="/admin/coupons/delete?id=<?= urlencode($c['id']) ?>" class="btn-danger" onclick="return confirm('Delete coupon <?= htmlspecialchars($c['code']) ?>?')">🗑 Delete</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="empty-state">
            <p style="font-size: 1.1rem;">🏷️ No coupons yet.</p>
            <p><a href="/admin/coupons/create" style="color: #6366f1; font-weight: 600;">Create your first coupon →</a></p>
        </div>
    <?php endif; ?>
</div>
