<style>
    .product-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start; }
    @media (max-width: 768px) { .product-layout { grid-template-columns: 1fr; gap: 2rem; } }

    .product-img-block { position: relative; }
    .product-img-main { width: 100%; border-radius: 24px; overflow: hidden; background: #f8fafc; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0; }
    .product-img-main img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
    .product-img-main:hover img { transform: scale(1.04); }
    .product-no-img { font-size: 6rem; color: #cbd5e1; }

    .breadcrumb { display: flex; align-items: center; gap: 0.5rem; color: #94a3b8; font-size: 0.85rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
    .breadcrumb a { color: #6366f1; text-decoration: none; font-weight: 500; }
    .breadcrumb a:hover { text-decoration: underline; }

    .product-category { font-size: 0.78rem; font-weight: 700; color: #6366f1; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 0.5rem; }
    .product-title { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color: #0f172a; line-height: 1.2; letter-spacing: -0.5px; margin-bottom: 1.25rem; }
    .product-price { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; }
    .product-price .currency { font-size: 1.2rem; vertical-align: super; color: #6366f1; }
    .product-desc { color: #475569; line-height: 1.8; font-size: 0.95rem; margin-bottom: 2rem; border-left: 3px solid #c4b5fd; padding-left: 1rem; }

    .qty-row { display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1.25rem; }
    .qty-label { font-size: 0.82rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .qty-wrap { display: flex; align-items: center; border: 1.5px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #fff; }
    .qty-btn { padding: 0.65rem 1rem; background: none; border: none; cursor: pointer; font-size: 1.1rem; color: #6366f1; font-weight: 700; transition: background 0.2s; }
    .qty-btn:hover { background: #f5f3ff; }
    .qty-input { width: 50px; text-align: center; border: none; outline: none; font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 700; color: #0f172a; }

    .btn-add-cart { width: 100%; padding: 1rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border: none; border-radius: 16px; font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all 0.25s; letter-spacing: 0.3px; }
    .btn-add-cart:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(99,102,241,0.4); }
    .btn-add-cart:active { transform: translateY(0); }

    .trust-badges { display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1.5rem; }
    .trust-item { display: flex; align-items: center; gap: 0.4rem; font-size: 0.8rem; color: #64748b; font-weight: 500; }

    /* Related */
    .related-section { margin-top: 4rem; }
    .related-title { font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; letter-spacing: -0.5px; }
    .related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.25rem; }
    .related-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; transition: all 0.3s; }
    .related-card:hover { transform: translateY(-4px); box-shadow: 0 16px 30px rgba(0,0,0,0.08); }
    .related-img { padding-top: 65%; position: relative; background: #f8fafc; overflow: hidden; }
    .related-img img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
    .related-no-img { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); font-size: 2.5rem; color: #cbd5e1; }
    .related-body { padding: 1rem; }
    .related-name { font-weight: 700; font-size: 0.9rem; color: #0f172a; text-decoration: none; display: block; margin-bottom: 0.4rem; }
    .related-price { font-weight: 800; color: #6366f1; font-size: 1rem; }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="/">Home</a>
    <span>›</span>
    <?php if (!empty($product['category_name'])): ?>
    <a href="/"><?= htmlspecialchars($product['category_name']) ?></a>
    <span>›</span>
    <?php endif; ?>
    <span><?= htmlspecialchars($product['title']) ?></span>
</div>

<div class="product-layout">
    <!-- Image -->
    <div class="product-img-block">
        <div class="product-img-main">
            <?php if (!empty($product['image'])): ?>
                <img src="/uploads/products/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
            <?php else: ?>
                <div class="product-no-img">📦</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Info -->
    <div class="product-info">
        <?php if (!empty($product['category_name'])): ?>
        <div class="product-category"><?= htmlspecialchars($product['category_name']) ?></div>
        <?php endif; ?>

        <h1 class="product-title"><?= htmlspecialchars($product['title']) ?></h1>

        <div class="product-price">
            <span class="currency">$</span><?= number_format($product['price'] ?? 0, 2) ?>
        </div>

        <?php if (!empty($product['description'])): ?>
        <div class="product-desc"><?= nl2br(htmlspecialchars($product['description'])) ?></div>
        <?php endif; ?>

        <form method="POST" action="/cart/add">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

            <div class="qty-row">
                <span class="qty-label">Qty</span>
                <div class="qty-wrap">
                    <button type="button" class="qty-btn" onclick="adjustQty(-1)">−</button>
                    <input type="number" name="quantity" id="qty-input" class="qty-input" value="1" min="1" max="99">
                    <button type="button" class="qty-btn" onclick="adjustQty(1)">+</button>
                </div>
            </div>

            <button type="submit" class="btn-add-cart">🛒 Add to Cart</button>
        </form>

        <div class="trust-badges">
            <div class="trust-item">🔒 Secure checkout</div>
            <div class="trust-item">🚚 Fast shipping</div>
            <div class="trust-item">↩ Free returns</div>
        </div>
    </div>
</div>

<?php if (!empty($related)): ?>
<div class="related-section">
    <div class="related-title">You Might Also Like</div>
    <div class="related-grid">
        <?php foreach ($related as $r): ?>
        <a href="/product/<?= urlencode($r['slug'] ?? $r['id']) ?>" style="text-decoration: none;">
            <div class="related-card">
                <div class="related-img">
                    <?php if (!empty($r['image'])): ?>
                        <img src="/uploads/products/<?= htmlspecialchars($r['image']) ?>" alt="<?= htmlspecialchars($r['title']) ?>">
                    <?php else: ?>
                        <span class="related-no-img">📦</span>
                    <?php endif; ?>
                </div>
                <div class="related-body">
                    <span class="related-name"><?= htmlspecialchars($r['title']) ?></span>
                    <div class="related-price">$<?= number_format($r['price'] ?? 0, 2) ?></div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<script>
function adjustQty(delta) {
    const input = document.getElementById('qty-input');
    const val = Math.max(1, Math.min(99, (parseInt(input.value) || 1) + delta));
    input.value = val;
}
</script>
