<style>
    .cart-layout { display: grid; grid-template-columns: 1fr 380px; gap: 3rem; align-items: start; }
    @media (max-width: 900px) { .cart-layout { grid-template-columns: 1fr; gap: 2rem; } }

    h1 { font-size: 2.5rem; font-weight: 900; color: #fff; margin-bottom: 2.5rem; letter-spacing: -1px; display: flex; align-items: center; gap: 0.75rem; text-shadow: 0 5px 20px rgba(0,0,0,0.5); }
    h1 svg { width: 32px; height: 32px; stroke: var(--m-cyan); fill: none; stroke-width: 2.5; stroke-linecap: round; }

    .btn-continue { display: inline-flex; align-items: center; gap: 0.5rem; color: var(--m-muted); text-decoration: none; font-weight: 700; font-size: 0.9rem; margin-bottom: 1.5rem; padding: 0.5rem 1rem; border-radius: 20px; border: 1px solid transparent; transition: all 0.3s; }
    .btn-continue:hover { color: var(--m-cyan); border-color: var(--m-border); background: rgba(255,255,255,0.02); transform: translateX(-4px); }
    .btn-continue svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 3; }

    /* Items table */
    .cart-items-block { background: var(--m-card); border: 1px solid var(--m-border); border-radius: 24px; padding: 1.5rem; position: relative; }
    .cart-items-block::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 20px; pointer-events: none; opacity: 0.2; }
    
    .cart-item { display: grid; grid-template-columns: 100px 1fr auto; gap: 1.5rem; align-items: center; padding: 1.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); position: relative; z-index: 2; }
    .cart-item:last-child { border-bottom: none; }
    .item-img { width: 100px; height: 100px; border-radius: 16px; overflow: hidden; background: rgba(0,0,0,0.4); border: 1px solid var(--m-border); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--m-muted); flex-shrink: 0; }
    .item-img img { width: 100%; height: 100%; object-fit: cover; }
    
    .item-name { font-weight: 800; color: #fff; font-size: 1.1rem; margin-bottom: 0.3rem; }
    .item-price { font-size: 0.95rem; color: var(--m-pink); font-weight: 700; }
    .item-qty { font-size: 0.85rem; color: var(--m-muted); font-weight: 600; margin-top: 0.5rem; display: inline-block; padding: 0.2rem 0.6rem; background: rgba(0,0,0,0.3); border-radius: 8px; }
    .item-total { font-weight: 900; font-size: 1.3rem; color: #fff; text-align: right; white-space: nowrap; }
    
    .cart-empty { text-align: center; padding: 6rem 2rem; color: var(--m-muted); background: var(--m-card); border-radius: 24px; border: var(--stitch-border); }

    /* Order Summary Card */
    .summary-card { background: rgba(22,26,45,0.8); backdrop-filter: blur(12px); border: 1px solid var(--m-border); border-radius: 24px; padding: 2rem; position: sticky; top: 100px; box-shadow: 0 10px 40px rgba(0,0,0,0.4); }
    .summary-card::before { content: ''; position: absolute; inset: 0; border-radius: 24px; padding: 2px; background: var(--gradient-magic); -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); -webkit-mask-composite: xor; mask-composite: exclude; pointer-events: none; opacity: 0.5; }
    
    .summary-title { font-size: 1.3rem; font-weight: 900; color: #fff; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .summary-row { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; color: var(--m-text); font-size: 0.95rem; font-weight: 600; }
    .summary-row.discount { color: var(--m-pink); font-weight: 800; }
    .summary-divider { border: none; border-top: 1px dashed var(--m-border); margin: 1rem 0; }
    .summary-total { display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; }
    .summary-total span:first-child { font-size: 1.1rem; font-weight: 800; color: #fff; }
    .summary-total span:last-child { font-size: 1.8rem; font-weight: 900; color: #fff; text-shadow: 0 0 15px rgba(255,255,255,0.2); }

    .btn-checkout { display: block; width: 100%; padding: 1.1rem; background: var(--gradient-magic); color: #fff; text-decoration: none; border-radius: 20px; font-family: var(--font-main); font-size: 1.1rem; font-weight: 900; text-align: center; transition: all 0.3s; margin-top: 1.5rem; border: none; cursor: pointer; position: relative; box-shadow: var(--shadow-magic); }
    .btn-checkout::before { content: ''; position: absolute; inset: 2px; border: 1px dashed rgba(255,255,255,0.5); border-radius: 18px; }
    .btn-checkout:hover { transform: translateY(-2px); box-shadow: 0 15px 40px rgba(139,92,246,0.4); animation: stitch-glow 1.5s infinite alternate; }

    /* Coupon */
    .coupon-section { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed var(--m-border); }
    .coupon-label { font-size: 0.85rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem; display: flex; align-items: center; gap: 0.4rem; }
    .coupon-applied { display: flex; align-items: center; gap: 0.75rem; background: rgba(217,70,239,0.1); border: 1px solid var(--m-pink); border-radius: 12px; padding: 0.8rem 1.25rem; color: var(--m-pink); font-size: 0.9rem; font-weight: 800; }
    .coupon-applied a { margin-left: auto; color: var(--m-muted); font-size: 0.8rem; text-decoration: none; font-weight: 700; transition: color 0.2s; }
    .coupon-applied a:hover { color: #f43f5e; }
    
    .coupon-row { display: flex; gap: 0.5rem; }
    .coupon-input { flex: 1; padding: 0.8rem 1.25rem; border: 1px solid var(--m-border); border-radius: 12px; font-family: var(--font-main); font-size: 0.95rem; color: #fff; background: rgba(0,0,0,0.3); transition: all 0.3s; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; }
    .coupon-input:focus { outline: none; border-color: var(--m-cyan); box-shadow: 0 0 15px rgba(6,182,212,0.2); }
    .coupon-btn { padding: 0.8rem 1.25rem; background: rgba(255,255,255,0.05); color: var(--m-text); border: 1px solid var(--m-border); border-radius: 12px; font-family: var(--font-main); font-weight: 800; font-size: 0.9rem; cursor: pointer; transition: all 0.3s; white-space: nowrap; }
    .coupon-btn:hover { background: rgba(6,182,212,0.15); color: var(--m-cyan); border-color: var(--m-cyan); }
    
    .coupon-error { background: rgba(244,63,94,0.1); border: 1px solid #f43f5e; color: #fda4af; border-radius: 10px; padding: 0.6rem 1rem; font-size: 0.85rem; font-weight: 600; margin-top: 0.75rem; }
    .coupon-success { background: rgba(6,182,212,0.1); border: 1px solid var(--m-cyan); color: #67e8f9; border-radius: 10px; padding: 0.6rem 1rem; font-size: 0.85rem; font-weight: 600; margin-top: 0.75rem; }
</style>

<a href="/" class="btn-continue">
    <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
    Return to Cosmos
</a>

<h1>
    <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
    Magical Cart
</h1>

<?php if (!empty($items)): ?>

<?php
$couponError   = $_SESSION['coupon_error'] ?? null;
$couponSuccess = $_SESSION['coupon_success'] ?? null;
unset($_SESSION['coupon_error'], $_SESSION['coupon_success']);
?>

<div class="cart-layout">
    <!-- Items -->
    <div class="cart-items-block">
        <?php foreach ($items as $item): ?>
        <div class="cart-item">
            <div class="item-img">
                <?php if (!empty($item['image'])): ?>
                    <img src="/uploads/products/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                <?php else: ?>
                    🌌
                <?php endif; ?>
            </div>
            <div>
                <div class="item-name"><?= htmlspecialchars($item['title']) ?></div>
                <div class="item-price"><span style="color:var(--m-muted);font-size:0.8rem;">$</span><?= number_format($item['price'] ?? 0, 2) ?> <span style="font-size:0.75rem; color:var(--m-muted); font-weight:500;">/ piece</span></div>
                <div class="item-qty">Quantity: <?= (int)($item['quantity'] ?? 1) ?></div>
            </div>
            <div class="item-total">$<?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Summary -->
    <div class="summary-card">
        <div class="summary-title">Orbital Summary</div>

        <div class="summary-row">
            <span>Base Cost</span>
            <span>$<?= number_format($subtotal ?? 0, 2) ?></span>
        </div>

        <?php if (!empty($coupon) && ($discount ?? 0) > 0): ?>
        <div class="summary-row discount">
            <span>Enchantment (<?= htmlspecialchars($coupon['code']) ?>)</span>
            <span>−$<?= number_format($discount, 2) ?></span>
        </div>
        <?php endif; ?>

        <div class="summary-row">
            <span>Teleportation Fee</span>
            <span style="color: var(--m-cyan); font-weight: 800; text-transform:uppercase; letter-spacing:1px; font-size:0.8rem;">Waived</span>
        </div>

        <hr class="summary-divider">

        <div class="summary-total">
            <span>Final Tribute</span>
            <span>$<?= number_format($total ?? 0, 2) ?></span>
        </div>

        <a href="/checkout" class="btn-checkout">Proceed to Checkout →</a>

        <!-- Coupon Section -->
        <div class="coupon-section">
            <div class="coupon-label">
                <svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                Apply Enchantment Rune
            </div>
            <?php if (!empty($coupon)): ?>
                <div class="coupon-applied">
                    ✨ <?= htmlspecialchars($coupon['code']) ?> Activated!
                    <a href="/cart/coupon/remove">✕ Dispel</a>
                </div>
            <?php else: ?>
                <form method="POST" action="/cart/coupon/apply">
                    <div class="coupon-row">
                        <input type="text" name="coupon_code" class="coupon-input" placeholder="RUNE CODE" value="<?= htmlspecialchars($_POST['coupon_code'] ?? '') ?>">
                        <button type="submit" class="coupon-btn">Invoke</button>
                    </div>
                </form>
                <?php if ($couponError): ?>
                <div class="coupon-error">⚠ <?= htmlspecialchars($couponError) ?></div>
                <?php elseif ($couponSuccess): ?>
                <div class="coupon-success">✨ <?= htmlspecialchars($couponSuccess) ?></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php else: ?>
<div class="cart-empty">
    <svg style="width:80px;height:80px;stroke:var(--m-border);fill:none;stroke-width:1;" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
    <p style="font-size: 1.5rem; font-weight: 900; color: #fff; margin: 1.5rem 0 0.5rem;">Your cart resists gravity.</p>
    <p style="margin-bottom: 2rem;">It is entirely empty.</p>
    <a href="/" class="btn-checkout" style="display: inline-block; width: auto; padding: 1rem 2.5rem;">Summon Items</a>
</div>
<?php endif; ?>
