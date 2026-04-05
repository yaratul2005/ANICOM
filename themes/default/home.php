<style>
    /* Hero Banner */
    .hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #312e81 100%);
        border-radius: 24px; padding: 4rem 3rem; margin-bottom: 3rem;
        color: #fff; position: relative; overflow: hidden;
    }
    .hero::before {
        content: ''; position: absolute; top: -100px; right: -100px;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(129,140,248,0.3) 0%, transparent 70%);
    }
    .hero::after {
        content: ''; position: absolute; bottom: -80px; left: 200px;
        width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(circle, rgba(192,132,252,0.2) 0%, transparent 70%);
    }
    .hero-content { position: relative; z-index: 1; max-width: 520px; }
    .hero h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.15; letter-spacing: -1px; margin-bottom: 1rem; }
    .hero h1 span { background: linear-gradient(90deg, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero p { color: rgba(255,255,255,0.65); font-size: 1.05rem; margin-bottom: 2rem; line-height: 1.7; }
    .hero-cta { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.9rem 2rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; text-decoration: none; border-radius: 30px; font-weight: 700; font-size: 1rem; transition: all 0.25s; box-shadow: 0 8px 30px rgba(99,102,241,0.4); }
    .hero-cta:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(99,102,241,0.5); }

    /* Section Header */
    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; }
    .section-title { font-size: 1.5rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; }
    .section-subtitle { color: #64748b; font-size: 0.9rem; margin-top: 0.2rem; }

    /* Category Filter */
    .category-tabs { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 2.5rem; }
    .cat-tab { padding: 0.45rem 1.1rem; border: 1.5px solid #e2e8f0; border-radius: 25px; color: #64748b; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: all 0.2s; cursor: pointer; background: #fff; }
    .cat-tab:hover, .cat-tab.active { border-color: #6366f1; background: #ede9fe; color: #6366f1; }

    /* Product Grid */
    .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.75rem; }

    /* Product Card */
    .product-card {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 20px;
        overflow: hidden; transition: all 0.3s ease;
        display: flex; flex-direction: column;
    }
    .product-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); border-color: #c4b5fd; }

    .card-img-wrap { position: relative; padding-top: 70%; overflow: hidden; background: #f8fafc; }
    .card-img-wrap img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
    .product-card:hover .card-img-wrap img { transform: scale(1.06); }
    .card-no-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; color: #cbd5e1; }
    .card-badge { position: absolute; top: 12px; left: 12px; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 0.25rem 0.65rem; border-radius: 20px; z-index: 2; }

    .card-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; gap: 0.5rem; }
    .card-category { font-size: 0.72rem; font-weight: 700; color: #6366f1; text-transform: uppercase; letter-spacing: 0.8px; }
    .card-title { font-size: 1rem; font-weight: 700; color: #0f172a; text-decoration: none; line-height: 1.4; transition: color 0.2s; }
    .card-title:hover { color: #6366f1; }
    .card-price { font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: auto; padding-top: 0.5rem; }
    .card-price .original { font-size: 0.85rem; color: #94a3b8; text-decoration: line-through; font-weight: 400; margin-left: 0.4rem; }

    .btn-add { width: 100%; padding: 0.75rem; background: #f5f3ff; color: #6366f1; border: 2px solid #c4b5fd; border-radius: 12px; font-family: 'Inter', sans-serif; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: all 0.2s; margin-top: 0.75rem; }
    .btn-add:hover { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border-color: transparent; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.3); }

    /* Empty state */
    .empty { text-align: center; padding: 5rem 2rem; color: #94a3b8; }
    .empty-icon { font-size: 4rem; margin-bottom: 1rem; }
</style>

<!-- Hero Banner -->
<div class="hero">
    <div class="hero-content">
        <h1>Shop <span>Everything</span><br>You Love</h1>
        <p>Discover a curated collection of premium products delivered fast, backed by our zero-hassle return policy.</p>
        <a href="#products" class="hero-cta">Browse Products ↓</a>
    </div>
</div>

<!-- Category Filter -->
<?php if (!empty($categories)): ?>
<div class="category-tabs">
    <a href="/" class="cat-tab active">All Products</a>
    <?php foreach ($categories as $cat): ?>
    <a href="/?category=<?= urlencode($cat['slug'] ?? $cat['id']) ?>" class="cat-tab">
        <?= htmlspecialchars($cat['name']) ?>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Products Section -->
<div id="products">
    <div class="section-header">
        <div>
            <div class="section-title">Featured Products</div>
            <div class="section-subtitle"><?= count($products ?? []) ?> products available</div>
        </div>
    </div>

    <?php if (!empty($products)): ?>
    <div class="products-grid">
        <?php foreach ($products as $product): ?>
        <div class="product-card">
            <a href="/product/<?= urlencode($product['slug'] ?? $product['id']) ?>">
                <div class="card-img-wrap">
                    <?php if (!empty($product['image'])): ?>
                        <img src="/uploads/products/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="card-no-img">📦</div>
                    <?php endif; ?>
                    <?php if (!empty($product['is_new'])): ?>
                    <span class="card-badge">New</span>
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
                    $<?= number_format($product['price'] ?? 0, 2) ?>
                </div>
                <form method="POST" action="/cart/add">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-add">Add to Cart</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty">
        <div class="empty-icon">🛍️</div>
        <p style="font-size: 1.2rem; font-weight: 600;">No products yet</p>
        <p>Add your first product from the <a href="/admin/products/create" style="color: #6366f1;">admin panel</a>.</p>
    </div>
    <?php endif; ?>
</div>
