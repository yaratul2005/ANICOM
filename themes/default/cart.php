<style>
    .cart-layout { display: grid; grid-template-columns: 1fr 360px; gap: 2.5rem; align-items: start; }
    @media (max-width: 900px) { .cart-layout { grid-template-columns: 1fr; } }

    h1 { font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 2rem; letter-spacing: -0.5px; }

    /* Items table */
    .cart-item { display: grid; grid-template-columns: 80px 1fr auto auto; gap: 1.25rem; align-items: center; padding: 1.25rem 0; border-bottom: 1px solid #f1f5f9; }
    .cart-item:last-child { border-bottom: none; }
    .item-img { width: 80px; height: 80px; border-radius: 12px; overflow: hidden; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #cbd5e1; flex-shrink: 0; }
    .item-img img { width: 100%; height: 100%; object-fit: cover; }
    .item-name { font-weight: 700; color: #0f172a; font-size: 0.95rem; }
    .item-price { font-size: 0.85rem; color: #64748b; margin-top: 0.25rem; }
    .item-qty { font-size: 0.82rem; color: #94a3b8; }
    .item-total { font-weight: 800; font-size: 1.05rem; color: #0f172a; text-align: right; white-space: nowrap; }
    .cart-empty { text-align: center; padding: 4rem 2rem; color: #94a3b8; }

    /* Order Summary Card */
    .summary-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 1.75rem; position: sticky; top: 100px; }
    .summary-title { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; }
    .summary-row { display: flex; justify-content: space-between; align-items: center; padding: 0.6rem 0; color: #475569; font-size: 0.9rem; }
    .summary-row.discount { color: #16a34a; font-weight: 600; }
    .summary-divider { border: none; border-top: 1px dashed #e2e8f0; margin: 0.75rem 0; }
    .summary-total { display: flex; justify-content: space-between; align-items: center; padding-top: 0.75rem; }
    .summary-total span:first-child { font-size: 1rem; font-weight: 700; color: #0f172a; }
    .summary-total span:last-child { font-size: 1.5rem; font-weight: 800; color: #0f172a; }

    .btn-checkout { display: block; width: 100%; padding: 1rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; text-decoration: none; border-radius: 14px; font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 700; text-align: center; transition: all 0.25s; margin-top: 1.25rem; border: none; cursor: pointer; }
    .btn-checkout:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(99,102,241,0.4); }

    /* Coupon */
    .coupon-section { margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px dashed #e2e8f0; }
    .coupon-label { font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.65rem; }
    .coupon-applied { display: flex; align-items: center; gap: 0.6rem; background: #dcfce7; border: 1px solid #bbf7d0; border-radius: 10px; padding: 0.65rem 1rem; color: #166534; font-size: 0.85rem; font-weight: 600; }
    .coupon-applied a { margin-left: auto; color: #dc2626; font-size: 0.75rem; text-decoration: none; font-weight: 600; }
    .coupon-row { display: flex; gap: 0.5rem; }
    .coupon-input { flex: 1; padding: 0.65rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-family: 'Inter', sans-serif; font-size: 0.9rem; color: #1e293b; transition: border-color 0.2s; text-transform: uppercase; letter-spacing: 1px; }
    .coupon-input:focus { outline: none; border-color: #6366f1; }
    .coupon-btn { padding: 0.65rem 1.1rem; background: #0f172a; color: #fff; border: none; border-radius: 10px; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: background 0.2s; white-space: nowrap; }
    .coupon-btn:hover { background: #1e293b; }
    .coupon-error { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.82rem; font-weight: 500; margin-top: 0.5rem; }
    .coupon-success { background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.82rem; font-weight: 500; margin-top: 0.5rem; }

    .btn-continue { display: inline-flex; align-items: center; gap: 0.4rem; color: #6366f1; text-decoration: none; font-weight: 600; font-size: 0.9rem; margin-bottom: 1.5rem; }
    .btn-continue:hover { opacity: 0.8; }
</style>

<a href="/" class="btn-continue">← Continue Shopping</a>
<h1>Shopping Cart</h1>

<?php if (!empty($items)): ?>

<?php
$couponError   = $_SESSION['coupon_error'] ?? null;
$couponSuccess = $_SESSION['coupon_success'] ?? null;
unset($_SESSION['coupon_error'], $_SESSION['coupon_success']);
?>

<div class="cart-layout">
    <!-- Items -->
    <div class="cart-items-block" style="background:#fff; border:1px solid #e2e8f0; border-radius:20px; padding:1.5rem;">
        <?php foreach ($items as $item): ?>
        <div class="cart-item">
            <div class="item-img">
                <?php if (!empty($item['image'])): ?>
                    <img src="/uploads/products/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                <?php else: ?>
                    📦
                <?php endif; ?>
            </div>
            <div>
                <div class="item-name"><?= htmlspecialchars($item['title']) ?></div>
                <div class="item-price">$<?= number_format($item['price'] ?? 0, 2) ?> each</div>
                <div class="item-qty">Qty: <?= (int)($item['quantity'] ?? 1) ?></div>
            </div>
            <div></div>
            <div class="item-total">$<?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Summary -->
    <div class="summary-card">
        <div class="summary-title">Order Summary</div>

        <div class="summary-row">
            <span>Subtotal</span>
            <span>$<?= number_format($subtotal ?? 0, 2) ?></span>
        </div>

        <?php if (!empty($coupon) && ($discount ?? 0) > 0): ?>
        <div class="summary-row discount">
            <span>Coupon (<?= htmlspecialchars($coupon['code']) ?>)</span>
            <span>−$<?= number_format($discount, 2) ?></span>
        </div>
        <?php endif; ?>

        <div class="summary-row">
            <span>Shipping</span>
            <span style="color: #16a34a; font-weight: 600;">Free</span>
        </div>

        <hr class="summary-divider">

        <div class="summary-total">
            <span>Total</span>
            <span>$<?= number_format($total ?? 0, 2) ?></span>
        </div>

        <a href="/checkout" class="btn-checkout">Proceed to Checkout →</a>

        <!-- Coupon Section -->
        <div class="coupon-section">
            <div class="coupon-label">Have a coupon?</div>
            <?php if (!empty($coupon)): ?>
                <div class="coupon-applied">
                    🏷️ <?= htmlspecialchars($coupon['code']) ?> applied!
                    <a href="/cart/coupon/remove">✕ Remove</a>
                </div>
            <?php else: ?>
                <form method="POST" action="/cart/coupon/apply">
                    <div class="coupon-row">
                        <input type="text" name="coupon_code" class="coupon-input" placeholder="ENTER CODE" value="<?= htmlspecialchars($_POST['coupon_code'] ?? '') ?>">
                        <button type="submit" class="coupon-btn">Apply</button>
                    </div>
                </form>
                <?php if ($couponError): ?>
                <div class="coupon-error">⚠ <?= htmlspecialchars($couponError) ?></div>
                <?php elseif ($couponSuccess): ?>
                <div class="coupon-success">✅ <?= htmlspecialchars($couponSuccess) ?></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php else: ?>
<div class="cart-empty">
    <p style="font-size: 4rem; margin-bottom: 1rem;">🛒</p>
    <p style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.75rem;">Your cart is empty</p>
    <p style="margin-bottom: 1.5rem;">Looks like you haven't added anything yet.</p>
    <a href="/" style="display: inline-block; padding: 0.85rem 2rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border-radius: 14px; font-weight: 700; text-decoration: none;">Browse Products</a>
</div>
<?php endif; ?>
