<style>
    .product-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start; }
    @media (max-width: 900px) { .product-layout { grid-template-columns: 1fr; gap: 3rem; } }

    .product-img-main { width: 100%; border-radius: 28px; overflow: hidden; background: rgba(0,0,0,0.3); border: 1px solid var(--m-border); aspect-ratio: 1; display: flex; align-items: center; justify-content: center; position: relative; margin-bottom: 1rem; cursor: pointer; transition: all 0.3s; }
    .product-img-main img { width: 100%; height: 100%; object-fit: cover; }
    .product-img-main::after { content:''; position:absolute; inset:8px; border: var(--stitch-border); border-radius: 20px; pointer-events:none; opacity: 0.5; }

    .media-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 1rem; }
    .media-thumb { border-radius: 12px; overflow: hidden; aspect-ratio: 1; border: 1px solid var(--m-border); cursor: pointer; opacity: 0.6; transition: all 0.2s; }
    .media-thumb:hover, .media-thumb.active { opacity: 1; border-color: var(--m-cyan); }
    .media-thumb img { width: 100%; height: 100%; object-fit: cover; }

    .breadcrumb { display: flex; align-items: center; gap: 0.75rem; color: var(--m-muted); font-size: 0.85rem; margin-bottom: 2rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
    .breadcrumb a { color: var(--m-cyan); text-decoration: none; transition: color 0.2s; }
    .breadcrumb a:hover { color: var(--m-pink); }
    .breadcrumb svg { width:12px; height:12px; stroke:currentColor; fill:none; stroke-width:3; }

    .product-category { font-size: 0.8rem; font-weight: 900; color: var(--m-pink); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; }
    .product-title { font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; color: #fff; line-height: 1.1; letter-spacing: -1px; margin-bottom: 1.5rem; text-shadow: 0 4px 20px rgba(0,0,0,0.5); }
    
    .product-price { font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 2rem; display: flex; align-items: flex-end; gap: 0.75rem; }
    .product-price .currency { font-size: 1.2rem; color: var(--m-purple); margin-bottom:0.4rem; }
    .price-discounted { color: var(--m-muted); text-decoration: line-through; font-size: 1.2rem; font-weight: 600; opacity: 0.7; margin-bottom:0.3rem;}

    .product-desc { color: var(--m-text); line-height: 1.8; font-size: 1.05rem; margin-bottom: 2.5rem; position: relative; padding-left: 1.5rem; }
    .product-desc::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: var(--gradient-magic); border-radius: 3px; }

    .qty-row { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.5rem; }
    .qty-label { font-size: 0.85rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 1px; }
    .qty-wrap { display: flex; align-items: center; border: 1px solid var(--m-border); border-radius: 16px; overflow: hidden; background: rgba(0,0,0,0.2); }
    .qty-btn { padding: 0.8rem 1.2rem; background: none; border: none; cursor: pointer; color: var(--m-text); font-weight: 800; transition: all 0.2s; display: flex; align-items: center; justify-content: center; }
    .qty-btn:hover { background: rgba(255,255,255,0.05); color: var(--m-cyan); }
    .qty-input { width: 60px; text-align: center; border: none; outline: none; font-family: var(--font-main); font-size: 1.1rem; font-weight: 800; color: #fff; background: transparent; }

    .btn-add-cart { width: 100%; padding: 1.25rem; background: var(--gradient-magic); color: #fff; border: none; border-radius: 20px; font-family: var(--font-main); font-size: 1.1rem; font-weight: 900; cursor: pointer; transition: all 0.3s; letter-spacing: 0.5px; position: relative; display: flex; align-items: center; justify-content: center; gap: 0.75rem; box-shadow: var(--shadow-magic); overflow: hidden; }
    .btn-add-cart::before { content: ''; position: absolute; inset: 2px; border: 2px dashed rgba(255,255,255,0.4); border-radius: 18px; pointer-events: none; }
    .btn-add-cart:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(139,92,246,0.4); animation: stitch-glow 1.5s infinite alternate; }

    .trust-badges { display: flex; flex-direction: column; gap: 1rem; margin-top: 2.5rem; padding: 1.5rem; background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px; }
    .trust-item { display: flex; align-items: center; gap: 0.75rem; font-size: 0.9rem; color: var(--m-text); font-weight: 600; }
    .trust-icon { width: 20px; height: 20px; stroke: var(--m-cyan); fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    .related-section { margin-top: 6rem; }
    .related-title { font-size: 1.8rem; font-weight: 900; color: #fff; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; }
    .related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem; }
</style>

<div class="breadcrumb">
    <a href="/">Home</a>
    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <?php if (!empty($product['category_name'])): ?>
    <a href="/"><?= htmlspecialchars($product['category_name']) ?></a>
    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <?php endif; ?>
    <span style="color:#fff;"><?= htmlspecialchars($product['title']) ?></span>
</div>

<div class="product-layout">
    <!-- Image block -->
    <div>
        <?php 
        $media = [];
        if (!empty($product['media'])) {
            $media = json_decode($product['media'], true);
        } elseif (!empty($product['image'])) {
            $media = [$product['image']];
        }
        $mainImage = !empty($media) ? $media[0] : null;
        ?>

        <div class="product-img-main" id="main-view">
            <?php if ($mainImage): ?>
                <img src="/uploads/products/<?= htmlspecialchars($mainImage) ?>" id="main-img" alt="<?= htmlspecialchars($product['title']) ?>">
            <?php else: ?>
                <span style="font-size: 4rem; opacity: 0.2;">🌌</span>
            <?php endif; ?>
        </div>

        <?php if (count($media) > 1): ?>
        <div class="media-gallery">
            <?php foreach ($media as $idx => $m): ?>
            <div class="media-thumb <?= $idx === 0 ? 'active' : '' ?>" onclick="switchMedia('<?= htmlspecialchars($m) ?>', this)">
                <img src="/uploads/products/<?= htmlspecialchars($m) ?>" alt="Gallery <?= $idx ?>">
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Info block -->
    <div>
        <?php if (!empty($product['category_name'])): ?>
        <div class="product-category">
            <svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <?= htmlspecialchars($product['category_name']) ?>
        </div>
        <?php endif; ?>

        <h1 class="product-title"><?= htmlspecialchars($product['title']) ?></h1>

        <div class="product-price">
            <?php 
            $price = (float)($product['price'] ?? 0);
            $compare = (float)($product['compare_at_price'] ?? 0);
            ?>
            <?php if ($compare > $price && $compare > 0): ?>
                <span class="price-discounted">$<?= number_format($compare, 2) ?></span>
            <?php endif; ?>
            <span><span class="currency">$</span><?= number_format($price, 2) ?></span>
        </div>

        <?php if (!empty($product['description'])): ?>
        <div class="product-desc"><?= $product['description'] ?></div>
        <?php endif; ?>

        <form method="POST" action="/cart/add">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

            <div class="qty-row">
                <span class="qty-label">Quantity</span>
                <div class="qty-wrap">
                    <button type="button" class="qty-btn" onclick="adjustQty(-1)"><svg style="width:16px;height:16px;stroke:currentColor;stroke-width:3;" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>
                    <input type="number" name="quantity" id="qty-input" class="qty-input" value="1" min="1" max="99">
                    <button type="button" class="qty-btn" onclick="adjustQty(1)"><svg style="width:16px;height:16px;stroke:currentColor;stroke-width:3;" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>
                </div>
            </div>

            <button type="submit" class="btn-add-cart">
                <svg style="width:20px;height:20px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                Summon to Cart
            </button>
        </form>

        <div class="trust-badges">
            <div class="trust-item"><svg class="trust-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> Magically Encrypted Checkout</div>
            <div class="trust-item"><svg class="trust-icon" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> Cosmic Fast Shipping</div>
            <div class="trust-item"><svg class="trust-icon" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg> Infinite Free Returns</div>
        </div>
    </div>
</div>

<?php if (!empty($related)): ?>
<div class="related-section">
    <div class="related-title">
        <svg style="width:28px;height:28px;stroke:var(--m-purple);fill:none;stroke-width:2;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg> 
        More Enchantments
    </div>
    <div class="related-grid products-grid">
        <!-- Re-use magico cards -->
        <?php foreach ($related as $r): ?>
        <div class="card-magico" style="display: flex; flex-direction: column;">
            <a href="/product/<?= urlencode($r['slug'] ?? $r['id']) ?>">
                <div class="card-img-wrap" style="padding-top: 80%;">
                    <?php if (!empty($r['image'])): ?>
                        <img src="/uploads/products/<?= htmlspecialchars($r['image']) ?>" alt="<?= htmlspecialchars($r['title']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="card-no-img">🌌</div>
                    <?php endif; ?>
                </div>
            </a>
            <div class="card-body">
                <a href="/product/<?= urlencode($r['slug'] ?? $r['id']) ?>" class="card-title" style="font-size:1rem;">
                    <?= htmlspecialchars($r['title']) ?>
                </a>
                <div class="card-price" style="font-size:1.1rem; padding-top:0.5rem; margin-top:0;">
                    <span class="currency" style="font-size:0.8rem;">$</span><?= number_format($r['price'] ?? 0, 2) ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<script>
<script>
function adjustQty(delta) {
    const input = document.getElementById('qty-input');
    const val = Math.max(1, Math.min(99, (parseInt(input.value) || 1) + delta));
    input.value = val;
}
function switchMedia(filename, thumbEl) {
    document.getElementById('main-img').src = '/uploads/products/' + filename;
    document.querySelectorAll('.media-thumb').forEach(el => el.classList.remove('active'));
    thumbEl.classList.add('active');
}
</script>
