<div style="max-width: 600px; margin: 0 auto; padding-top: 2rem;">
    <h1 style="margin-top: 0; color: #0f172a;">Secure Checkout</h1>

    <?php if (empty($items)): ?>
        <p>No items to checkout.</p>
    <?php else: ?>
        <div style="background: #f8fafc; padding: 2rem; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
            <h3 style="margin-top: 0;">Order Summary</h3>
            <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e2e8f0;">
                <?php foreach ($items as $item): ?>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #475569;">
                        <span><?= $item['quantity'] ?>x <?= htmlspecialchars($item['product']['title'], ENT_QUOTES) ?></span>
                        <span>$<?= number_format((float)($item['product']['price'] * $item['quantity']), 2) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1.25rem; color: #0f172a;">
                <span>Total</span>
                <span>$<?= number_format((float)$total, 2) ?></span>
            </div>
        </div>

        <form action="/checkout" method="POST">
            <h3 style="margin-bottom: 1rem;">Customer Information</h3>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Full Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; font-size: 1rem;">
            </div>
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; font-size: 1rem;">
            </div>

            <button type="submit" style="width: 100%; padding: 1rem; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 1.1rem; cursor: pointer;">Complete Order</button>
            <p style="text-align: center; color: #64748b; font-size: 0.85rem; margin-top: 1rem;">Payment processing logic bypassed for Native PHP verification.</p>
        </form>
    <?php endif; ?>
</div>
