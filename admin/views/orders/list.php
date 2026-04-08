<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 class="page-title" style="margin: 0;">Order Management</h2>
</div>

<div class="card" style="padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: #64748b;">Order ID</th>
                <th style="padding: 1rem 1.5rem; color: #64748b;">Customer</th>
                <th style="padding: 1rem 1.5rem; color: #64748b;">Total</th>
                <th style="padding: 1rem 1.5rem; color: #64748b;">Date</th>
                <th style="padding: 1rem 1.5rem; color: #64748b;">Status</th>
                <th style="padding: 1rem 1.5rem; color: #64748b; text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="6" style="padding: 2rem; text-align: center; color: #94a3b8;">No orders recorded yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $o): ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 1rem 1.5rem; font-weight: 500; font-family: monospace; color: #6366f1;"><?= htmlspecialchars($o['id'], ENT_QUOTES) ?></td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($o['customer_name'] ?? 'Unknown', ENT_QUOTES) ?></div>
                        <div style="font-size: 0.85rem; color: #64748b;"><?= htmlspecialchars($o['customer_email'] ?? '', ENT_QUOTES) ?></div>
                    </td>
                    <td style="padding: 1rem 1.5rem; font-weight: 600;">$<?= number_format((float)($o['total'] ?? 0), 2) ?></td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; font-size: 0.9rem;"><?= htmlspecialchars($o['created_at'] ?? 'N/A') ?></td>
                    <td style="padding: 1rem 1.5rem;">
                        <span style="padding: 0.25rem 0.75rem; background: <?= ($o['status'] === 'paid' || $o['status'] === 'shipped' || $o['status'] === 'completed') ? '#dcfce7' : '#fef9c3' ?>; color: <?= ($o['status'] === 'paid' || $o['status'] === 'shipped' || $o['status'] === 'completed') ? '#166534' : '#854d0e' ?>; border-radius: 20px; font-size: 0.85rem; font-weight: 600; text-transform: capitalize;">
                            <?= htmlspecialchars($o['status'] ?? 'pending', ENT_QUOTES) ?>
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <?php if(($o['status'] ?? 'pending') === 'pending_verification'): ?>
                            <button onclick="verifyOrder('<?= $o['id'] ?>', <?= (float)($o['total'] ?? 0) ?>)" style="color: #059669; text-decoration: none; font-size: 0.9rem; font-weight: 600; margin-right: 1rem; background: none; border: none; cursor: pointer;">Verify & Complete</button>
                        <?php endif; ?>
                        <?php if(($o['status'] ?? 'pending') === 'pending'): ?>
                            <a href="/admin/orders/status?id=<?= $o['id'] ?>&status=paid" style="color: #6366f1; text-decoration: none; font-size: 0.9rem; font-weight: 600; margin-right: 1rem;">Mark Paid</a>
                        <?php endif; ?>
                        <?php if(($o['status'] ?? '') === 'paid'): ?>
                            <a href="/admin/orders/status?id=<?= $o['id'] ?>&status=shipped" style="color: #6366f1; text-decoration: none; font-size: 0.9rem; font-weight: 600; margin-right: 1rem;">Mark Shipped</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
function verifyOrder(orderId, total) {
    if (confirm('Are you sure you want to verify and complete this order? This will trigger the purchase analytics.')) {
        // Update order status
        fetch('/admin/orders/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: orderId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Inject purchase pixel
                if (typeof fbq === 'function') {
                    fbq('track', 'Purchase', {
                        value: total,
                        currency: 'USD'
                    });
                }
                // Reload page to update status
                location.reload();
            } else {
                alert('Failed to verify order: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            alert('Error verifying order: ' + error.message);
        });
    }
}
</script>
