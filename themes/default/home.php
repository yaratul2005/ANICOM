<style>
    .hero {
        background: linear-gradient(135deg, rgba(7,9,19,0.8), rgba(22,26,45,0.9)), url('data:image/svg+xml;utf8,<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><filter id="noiseFilter"><feTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="3" stitchTiles="stitch"/></filter><rect width="100%" height="100%" filter="url(%23noiseFilter)" opacity="0.05"/></svg>');
        border-radius: 28px; padding: 5rem 3rem; margin-bottom: 3.5rem;
        position: relative; overflow: hidden;
        border: 1px solid var(--m-border);
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    }
    .hero::before {
        content: ''; position: absolute; top: -50%; right: -20%;
        width: 600px; height: 600px; border-radius: 50%;
        background: radial-gradient(circle, rgba(139,92,246,0.2) 0%, transparent 60%);
        animation: stitch-glow 6s infinite alternate;
    }
    .hero::after {
        content: ''; position: absolute; bottom: -30%; left: 10%;
        width: 400px; height: 400px; border-radius: 50%;
        background: radial-gradient(circle, rgba(6,182,212,0.15) 0%, transparent 60%);
    }

    .hero-content { position: relative; z-index: 1; max-width: 580px; }
    .hero h1 { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; line-height: 1.1; letter-spacing: -1.5px; margin-bottom: 1.25rem; }
    .hero h1 span { background: var(--gradient-magic); -webkit-background-clip: text; -webkit-text-fill-color: transparent; position: relative; }
    .hero h1 span::after { content: '✨'; position: absolute; font-size: 1.5rem; top: -15px; right: -30px; animation: magical-float 3s ease-in-out infinite; }
    
    .hero p { color: var(--m-muted); font-size: 1.15rem; margin-bottom: 2.5rem; line-height: 1.8; }
    
    .hero-cta { display: inline-flex; align-items: center; gap: 0.75rem; padding: 1.1rem 2.5rem; background: var(--gradient-magic); color: #fff; text-decoration: none; border-radius: 30px; font-weight: 800; font-size: 1.1rem; transition: all 0.3s; box-shadow: var(--shadow-magic); position: relative; }
    .hero-cta::before { content: ''; position: absolute; inset: 2px; border: 1px dashed rgba(255,255,255,0.6); border-radius: 30px; }
    .hero-cta:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 40px rgba(217,70,239,0.4); }

    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 2.5rem; }
    .section-title { font-size: 1.8rem; font-weight: 900; color: #fff; letter-spacing: -0.5px; display: flex; align-items: center; gap: 0.5rem; }
    .section-subtitle { color: var(--m-muted); font-size: 0.95rem; margin-top: 0.2rem; }

    .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }

    .card-img-wrap { position: relative; padding-top: 75%; overflow: hidden; background: rgba(0,0,0,0.3); border-radius: 16px; margin-bottom: 1.25rem; border: 1px solid var(--m-border); }
    .card-img-wrap img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1); }
    .card-magico:hover .card-img-wrap img { transform: scale(1.08); }
    .card-no-img { position: absolute; inset:0; display: flex; align-items: center; justify-content: center; font-size: 3rem; opacity: 0.2; }
    
    .card-badge { position: absolute; top: 12px; left: 12px; background: var(--gradient-magic); color: #fff; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; padding: 0.35rem 0.85rem; border-radius: 20px; z-index: 2; box-shadow: var(--shadow-magic); }
    
    .card-body { display: flex; flex-direction: column; flex: 1; position: relative; z-index: 10; padding: 0 0.5rem; }
    .card-category { font-size: 0.75rem; font-weight: 800; color: var(--m-cyan); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.4rem; }
    .card-title { font-size: 1.1rem; font-weight: 800; color: #fff; text-decoration: none; line-height: 1.4; transition: color 0.2s; }
    .card-title:hover { color: var(--m-pink); }
    .card-price { font-size: 1.35rem; font-weight: 900; color: var(--m-text); margin-top: auto; padding-top: 0.75rem; display: flex; align-items: baseline; gap: 0.4rem; }
    .card-price .currency { font-size: 0.9rem; color: var(--m-purple); }

    .btn-add { width: 100%; padding: 0.85rem; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--m-border); border-radius: 16px; font-family: var(--font-main); font-size: 0.95rem; font-weight: 800; cursor: pointer; transition: all 0.3s; margin-top: 1rem; position: relative; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
    .btn-add:hover { background: var(--gradient-magic); border-color: transparent; transform: translateY(-2px); box-shadow: var(--shadow-magic); }
    .btn-add::before { content: ''; position: absolute; inset: 2px; border: 1px dashed rgba(255,255,255,0.3); border-radius: 16px; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
    .btn-add:hover::before { opacity: 1; }
    .btn-icon-svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    .category-tabs { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 3rem; }
    .cat-tab { padding: 0.6rem 1.4rem; border: 1px solid var(--m-border); border-radius: 30px; color: var(--m-muted); text-decoration: none; font-size: 0.9rem; font-weight: 700; transition: all 0.3s; background: var(--m-card); backdrop-filter: blur(8px); }
    .cat-tab:hover, .cat-tab.active { border-color: var(--m-purple); background: rgba(139,92,246,0.1); color: #fff; box-shadow: 0 0 15px rgba(139,92,246,0.2); }

    .empty { text-align: center; padding: 6rem 2rem; color: var(--m-muted); background: var(--m-card); border-radius: 24px; border: var(--stitch-border); }
</style>

<div class="hero">
    <div class="hero-content">
        <h1>Unleash <span>Magic</span><br>In Every Order.</h1>
        <p>A cosmic collection of premium, celestial products. Fast delivery, woven with absolute perfection.</p>
        <a href="#products" class="hero-cta">
            <svg class="btn-icon-svg" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Explore Universe
        </a>
    </div>
</div>

<?php if (!empty($categories)): ?>
<div class="category-tabs">
    <a href="/" class="cat-tab active">All Splendors</a>
    <?php foreach ($categories as $cat): ?>
    <a href="/?category=<?= urlencode($cat['slug'] ?? $cat['id']) ?>" class="cat-tab">
        <?= htmlspecialchars($cat['name']) ?>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div id="products">
    <div class="section-header">
        <div>
            <div class="section-title">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--m-pink)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                Featured Splendors
            </div>
            <div class="section-subtitle"><?= count($products ?? []) ?> magical items found</div>
        </div>
    </div>

    <?php if (!empty($products)): ?>
    <div class="products-grid">
        <?php foreach ($products as $product): ?>
        <div class="card-magico" style="display: flex; flex-direction: column;">
            <a href="/product/<?= urlencode($product['slug'] ?? $product['id']) ?>">
                <div class="card-img-wrap">
                    <?php if (!empty($product['image'])): ?>
                        <img src="/uploads/products/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="card-no-img">🌌</div>
                    <?php endif; ?>
                    <?php if (!empty($product['is_new'])): ?>
                    <span class="card-badge">Celestial Arrival</span>
                    <?php endif; ?>
                </div>
            </a>
            <div class="card-body">
                <?php if (!empty($product['category_name'])): ?>
                <div class="card-category"><?= htmlspecialchars($product['category_name']) ?></div>
                <?php endif; ?>
                <a href="/product/<?= urlencode($product['slug'] ?? $product['id']) ?>" class="card-title">
                    <?= htmlspecialchars($product['title']) ?>
                </a>
                <div class="card-price">
                    <span class="currency">$</span><?= number_format($product['price'] ?? 0, 2) ?>
                </div>
                <form method="POST" action="/cart/add" style="margin-top:auto;">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-add">
                        <svg class="btn-icon-svg" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg> Add to Cart
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty">
        <svg style="width:64px;height:64px;stroke:var(--m-border);fill:none;stroke-width:1;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <p style="font-size: 1.4rem; font-weight: 800; color: #fff; margin: 1rem 0 0.5rem;">The void is empty.</p>
        <p>Check back later for new arrivals.</p>
    </div>
    <?php endif; ?>
</div>
