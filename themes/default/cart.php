<div style="max-width: 800px; margin: 0 auto; padding-top: 2rem;">
    <h1 style="margin-top: 0; color: #0f172a;">Your Cart</h1>

    <?php if (empty($items)): ?>
        <div style="padding: 3rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; text-align: center;">
            <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 1.5rem;">Your cart is currently empty.</p>
            <a href="/" style="display: inline-block; padding: 0.75rem 2rem; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">Continue Shopping</a>
        </div>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 2rem;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; text-align: left;">
                    <th style="padding: 1rem 0; color: #64748b;">Product</th>
                    <th style="padding: 1rem 0; color: #64748b;">Price</th>
                    <th style="padding: 1rem 0; color: #64748b;">Qty</th>
                    <th style="padding: 1rem 0; color: #64748b; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 1.5rem 0; font-weight: 600; color: #0f172a;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <?php if(!empty($item['product']['image'])): ?>
                                    <img src="/uploads/products/<?= htmlspecialchars($item['product']['image'], ENT_QUOTES) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;" alt="">
                                <?php endif; ?>
                                <?= htmlspecialchars($item['product']['title'], ENT_QUOTES) ?>
                            </div>
                        </td>
                        <td style="padding: 1.5rem 0;">$<?= number_format((float)$item['product']['price'], 2) ?></td>
                        <td style="padding: 1.5rem 0;"><?= $item['quantity'] ?></td>
                        <td style="padding: 1.5rem 0; text-align: right; font-weight: 600;">$<?= number_format((float)($item['product']['price'] * $item['quantity']), 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 2rem; padding: 2rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
            <div style="text-align: right;">
                <span style="color: #64748b; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Subtotal</span>
                <div style="font-size: 2rem; font-weight: 700; color: #0f172a;">$<?= number_format((float)$total, 2) ?></div>
            </div>
            <a href="/checkout" style="padding: 1rem 2.5rem; background: #0f172a; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 1.1rem; transition: transform 0.2s;">Checkout Now -></a>
        </div>
    <?php endif; ?>
</div>
