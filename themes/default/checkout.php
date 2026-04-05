<style>
    .checkout-layout { display: grid; grid-template-columns: 1fr 380px; gap: 2.5rem; align-items: start; }
    @media (max-width: 900px) { .checkout-layout { grid-template-columns: 1fr; } }

    h1 { font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; letter-spacing: -0.5px; }
    .checkout-subtitle { color: #64748b; margin-bottom: 2rem; font-size: 0.9rem; }

    .form-section { background: #fff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 2rem; margin-bottom: 1.5rem; }
    .form-section-title { font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.6rem; }
    .form-section-title span { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; width: 26px; height: 26px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-grid .full { grid-column: 1 / -1; }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    label { font-size: 0.78rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #1e293b; transition: all 0.2s; width: 100%; }
    .form-control:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }

    /* Summary */
    .order-summary { background: #fff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 1.75rem; position: sticky; top: 100px; }
    .summary-title { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; }

    .summary-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc; }
    .summary-item:last-of-type { border-bottom: none; }
    .s-img { width: 44px; height: 44px; border-radius: 8px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; overflow: hidden; }
    .s-img img { width: 100%; height: 100%; object-fit: cover; }
    .s-name { font-size: 0.85rem; font-weight: 600; color: #0f172a; flex: 1; }
    .s-qty { font-size: 0.75rem; color: #94a3b8; }
    .s-price { font-weight: 700; font-size: 0.9rem; color: #0f172a; white-space: nowrap; }

    .summary-divider { border: none; border-top: 1px dashed #e2e8f0; margin: 1rem 0; }
    .summary-row { display: flex; justify-content: space-between; font-size: 0.88rem; color: #475569; padding: 0.3rem 0; }
    .summary-row.discount { color: #16a34a; font-weight: 600; }
    .summary-total-row { display: flex; justify-content: space-between; align-items: center; padding-top: 0.5rem; }
    .summary-total-row span:first-child { font-weight: 700; color: #0f172a; }
    .summary-total-row span:last-child { font-size: 1.5rem; font-weight: 800; color: #0f172a; }

    .btn-place-order { width: 100%; padding: 1.1rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border: none; border-radius: 14px; font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 800; cursor: pointer; transition: all 0.25s; margin-top: 1.25rem; letter-spacing: 0.3px; }
    .btn-place-order:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(99,102,241,0.4); }

    .secure-note { display: flex; align-items: center; justify-content: center; gap: 0.4rem; color: #94a3b8; font-size: 0.78rem; margin-top: 1rem; }
</style>

<h1>Checkout</h1>
<p class="checkout-subtitle">Almost there! Fill in your details to complete the order.</p>

<div class="checkout-layout">
    <!-- Form -->
    <div>
        <form method="POST" action="/checkout">
            <div class="form-section">
                <div class="form-section-title"><span>1</span> Contact Information</div>
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="name">Full Name</label>
                        <input id="name" type="text" name="name" class="form-control" value="<?= htmlspecialchars(\Core\Customer::current()['name'] ?? $_POST['name'] ?? '') ?>" placeholder="Jane Doe" required>
                    </div>
                    <div class="form-group full">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" name="email" class="form-control" value="<?= htmlspecialchars(\Core\Customer::current()['email'] ?? $_POST['email'] ?? '') ?>" placeholder="jane@example.com" required>
                    </div>
                    <div class="form-group full">
                        <label for="phone">Phone (Optional)</label>
                        <input id="phone" type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" placeholder="+1 555 000 0000">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title"><span>2</span> Shipping Address</div>
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="address">Street Address</label>
                        <input id="address" type="text" name="address" class="form-control" placeholder="123 Main Street" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input id="city" type="text" name="city" class="form-control" placeholder="New York" required>
                    </div>
                    <div class="form-group">
                        <label for="zip">ZIP / Postal Code</label>
                        <input id="zip" type="text" name="zip" class="form-control" placeholder="10001">
                    </div>
                    <div class="form-group full">
                        <label for="country">Country</label>
                        <input id="country" type="text" name="country" class="form-control" placeholder="United States">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title"><span>3</span> Payment</div>
                <p style="color: #64748b; font-size: 0.9rem; background: #f8fafc; padding: 1rem; border-radius: 10px; border: 1px solid #e2e8f0;">
                    💳 Payment gateway integration coming soon. Orders will be placed in <strong>pending</strong> status and confirmed manually.
                </p>
            </div>

            <button type="submit" class="btn-place-order" style="width:100%; margin-top: 0;">
                🛒 Place Order — $<?= number_format($total ?? 0, 2) ?>
            </button>
        </form>
    </div>

    <!-- Summary -->
    <div class="order-summary">
        <div class="summary-title">Your Order</div>

        <?php foreach ($items as $item): ?>
        <div class="summary-item">
            <div class="s-img">
                <?php if (!empty($item['image'])): ?>
                    <img src="/uploads/products/<?= htmlspecialchars($item['image']) ?>" alt="">
                <?php else: ?>
                    📦
                <?php endif; ?>
            </div>
            <div style="flex: 1;">
                <div class="s-name"><?= htmlspecialchars($item['title']) ?></div>
                <div class="s-qty">Qty: <?= (int)($item['quantity'] ?? 1) ?></div>
            </div>
            <div class="s-price">$<?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) ?></div>
        </div>
        <?php endforeach; ?>

        <hr class="summary-divider">

        <div class="summary-row"><span>Subtotal</span><span>$<?= number_format($subtotal ?? 0, 2) ?></span></div>
        <?php if (!empty($coupon) && ($discount ?? 0) > 0): ?>
        <div class="summary-row discount"><span>Discount (<?= htmlspecialchars($coupon['code']) ?>)</span><span>−$<?= number_format($discount, 2) ?></span></div>
        <?php endif; ?>
        <div class="summary-row"><span>Shipping</span><span style="color:#16a34a;font-weight:600;">Free</span></div>

        <hr class="summary-divider">

        <div class="summary-total-row">
            <span>Total</span>
            <span>$<?= number_format($total ?? 0, 2) ?></span>
        </div>

        <div class="secure-note">🔒 Secured with 256-bit SSL encryption</div>
    </div>
</div>
