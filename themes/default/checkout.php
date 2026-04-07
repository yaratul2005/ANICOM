<style>
    .checkout-layout { display: grid; grid-template-columns: 1fr 400px; gap: 3rem; align-items: start; }
    @media (max-width: 900px) { .checkout-layout { grid-template-columns: 1fr; gap: 2rem; } }

    h1 { font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem; letter-spacing: -1px; text-shadow: 0 4px 15px rgba(0,0,0,0.5); }
    .checkout-subtitle { color: var(--m-muted); margin-bottom: 2.5rem; font-size: 1.05rem; font-weight: 500; }

    .form-section { background: var(--m-card); border: 1px solid var(--m-border); border-radius: 24px; padding: 2.5rem; margin-bottom: 1.5rem; position: relative; }
    .form-section::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 20px; pointer-events: none; opacity: 0.2; }
    
    .form-section-title { font-size: 1.1rem; font-weight: 800; color: #fff; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; letter-spacing: 0.5px; position: relative; z-index: 2; }
    .form-section-title span { background: var(--gradient-magic); color: #fff; width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 900; box-shadow: 0 0 10px rgba(217,70,239,0.3); border: 1px dashed rgba(255,255,255,0.5); }
    
    .form-grid { display: grid; grid-template-columns: 1fr; gap: 1.25rem; position: relative; z-index: 2; }
    .form-group { display: flex; flex-direction: column; gap: 0.5rem; }
    label { font-size: 0.8rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 1px; }
    .form-control { padding: 0.85rem 1.25rem; border: 1px solid var(--m-border); border-radius: 12px; font-family: var(--font-main); font-size: 1rem; color: #fff; background: rgba(0,0,0,0.3); transition: all 0.3s; width: 100%; font-weight: 500; }
    .form-control:focus { outline: none; border-color: var(--m-cyan); background: rgba(0,0,0,0.5); box-shadow: 0 0 0 3px rgba(6,182,212,0.15); }
    .form-control::placeholder { color: #475569; }

    .cod-box { background: rgba(16,185,129,0.1); border: 1px dashed #10b981; border-radius: 14px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem; position: relative; z-index: 2; margin-top: 1rem; }
    .cod-icon { width: 40px; height: 40px; background: rgba(16,185,129,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #34d399; }
    .cod-icon svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; }
    .cod-text { flex: 1; }
    .cod-title { font-weight: 800; color: #34d399; font-size: 1.05rem; }
    .cod-desc { font-size: 0.85rem; color: var(--m-muted); font-weight: 500; margin-top: 0.2rem; }

    /* Summary */
    .order-summary { background: rgba(22,26,45,0.8); backdrop-filter: blur(12px); border: 1px solid var(--m-border); border-radius: 24px; padding: 2rem; position: sticky; top: 100px; box-shadow: 0 10px 40px rgba(0,0,0,0.4); }
    .order-summary::before { content: ''; position: absolute; inset: 0; border-radius: 24px; padding: 2px; background: var(--gradient-magic); -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); -webkit-mask-composite: xor; mask-composite: exclude; pointer-events: none; opacity: 0.4; }
    
    .summary-title { font-size: 1.25rem; font-weight: 900; color: #fff; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .summary-title svg { width: 22px; height: 22px; stroke: var(--m-purple); fill: none; stroke-width: 2.5; stroke-linecap: round; }

    .summary-item { display: flex; align-items: center; gap: 1rem; padding: 0.85rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .summary-item:last-of-type { border-bottom: none; }
    .s-img { width: 50px; height: 50px; border-radius: 12px; background: rgba(0,0,0,0.4); border: 1px solid var(--m-border); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; overflow: hidden; }
    .s-img img { width: 100%; height: 100%; object-fit: cover; }
    .s-name { font-size: 0.95rem; font-weight: 700; color: #fff; flex: 1; }
    .s-qty { font-size: 0.8rem; color: var(--m-muted); font-weight: 600; margin-top: 0.2rem; }
    .s-price { font-weight: 800; font-size: 1rem; color: var(--m-cyan); white-space: nowrap; }

    .summary-divider { border: none; border-top: 1px dashed var(--m-border); margin: 1.25rem 0; }
    .summary-row { display: flex; justify-content: space-between; font-size: 0.9rem; color: var(--m-text); padding: 0.4rem 0; font-weight: 600; }
    .summary-row.discount { color: var(--m-pink); font-weight: 800; }
    .summary-total-row { display: flex; justify-content: space-between; align-items: center; padding-top: 0.75rem; }
    .summary-total-row span:first-child { font-weight: 800; color: #fff; font-size: 1.1rem; }
    .summary-total-row span:last-child { font-size: 1.8rem; font-weight: 900; color: #fff; text-shadow: 0 0 15px rgba(255,255,255,0.2); }

    .btn-place-order { width: 100%; padding: 1.25rem; background: var(--gradient-magic); color: #fff; border: none; border-radius: 20px; font-family: var(--font-main); font-size: 1.1rem; font-weight: 900; cursor: pointer; transition: all 0.3s; margin-top: 1.5rem; letter-spacing: 0.5px; position: relative; box-shadow: var(--shadow-magic); z-index: 2; }
    .btn-place-order::before { content: ''; position: absolute; inset: 2px; border: 1px dashed rgba(255,255,255,0.5); border-radius: 18px; pointer-events: none; }
    .btn-place-order:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(217,70,239,0.4); animation: stitch-glow 1.5s infinite alternate; }

    .secure-note { display: flex; align-items: center; justify-content: center; gap: 0.5rem; color: var(--m-muted); font-size: 0.8rem; font-weight: 600; margin-top: 1.25rem; }
    .secure-note svg { width: 14px; height: 14px; stroke: var(--m-cyan); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
</style>

<!-- Pixel Injection for Initiate Checkout -->
<script>
    if (typeof fbq === 'function') {
        fbq('track', 'InitiateCheckout', {
            value: <?= (float)($total ?? 0) ?>,
            currency: 'USD',
            content_ids: <?= json_encode(array_column($items, 'id')) ?>,
            content_type: 'product'
        });
    }
</script>

<h1>Finalize Ritual</h1>
<p class="checkout-subtitle">Secure the coordinates for your cosmic delivery.</p>

<div class="checkout-layout">
    <!-- Form -->
    <div>
        <form method="POST" action="/checkout">
            <div class="form-section">
                <div class="form-section-title"><span>1</span> Delivery Operations</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input id="name" type="text" name="name" class="form-control" value="<?= htmlspecialchars(\Core\Customer::current()['name'] ?? $_POST['name'] ?? '') ?>" placeholder="First & Last Name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input id="phone" type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" placeholder="+1 555 000 0000" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Customer Address</label>
                        <textarea id="address" name="address" class="form-control" style="min-height: 100px; resize: vertical;" placeholder="Full Street Address, City, Region..." required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title"><span>2</span> Payment Method</div>
                
                <div class="cod-box">
                    <div class="cod-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 1v22"></path><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div class="cod-text">
                        <div class="cod-title">Cash on Delivery (COD)</div>
                        <div class="cod-desc">Pay physically with cosmos coins when the artifact arrives at your door.</div>
                    </div>
                    <input type="hidden" name="payment_method" value="COD">
                </div>
            </div>

            <button type="submit" class="btn-place-order" onclick="if(typeof fbq === 'function'){fbq('track', 'AddPaymentInfo');}">
                🚀 Confirm Order — $<?= number_format($total ?? 0, 2) ?>
            </button>
        </form>
    </div>

    <!-- Summary -->
    <div class="order-summary">
        <div class="summary-title">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Cargo Manifest
        </div>

        <?php foreach ($items as $item): ?>
        <div class="summary-item">
            <div class="s-img">
                <?php if (!empty($item['image'])): ?>
                    <img src="/uploads/products/<?= htmlspecialchars($item['image']) ?>" alt="">
                <?php else: ?>
                    🌌
                <?php endif; ?>
            </div>
            <div style="flex: 1;">
                <div class="s-name"><?= htmlspecialchars($item['title'] ?? 'Unknown Artifact') ?></div>
                <div class="s-qty">Qty: <?= (int)($item['quantity'] ?? 1) ?></div>
            </div>
            <div class="s-price">$<?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) ?></div>
        </div>
        <?php endforeach; ?>

        <hr class="summary-divider">

        <div class="summary-row"><span>Base Value</span><span>$<?= number_format($subtotal ?? 0, 2) ?></span></div>
        <?php if (!empty($coupon) && ($discount ?? 0) > 0): ?>
        <div class="summary-row discount"><span>Enchantment (<?= htmlspecialchars($coupon['code']) ?>)</span><span>−$<?= number_format($discount, 2) ?></span></div>
        <?php endif; ?>
        <div class="summary-row"><span>Teleportation</span><span style="color:var(--m-cyan);font-weight:800;letter-spacing:1px;font-size:0.8rem;text-transform:uppercase;">Waived</span></div>

        <hr class="summary-divider">

        <div class="summary-total-row">
            <span>Final Tribute</span>
            <span>$<?= number_format($total ?? 0, 2) ?></span>
        </div>

        <div class="secure-note">
            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            Secured via Quantum Cryptography
        </div>
    </div>
</div>
