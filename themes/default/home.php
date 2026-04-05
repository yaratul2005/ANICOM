<?php
// Storefront Home Layout
// Includes dynamic grid presentation
?>
<div style="background: linear-gradient(135deg, #1e293b, #0f172a); color: white; padding: 4rem 2rem; border-radius: 12px; margin-bottom: 3rem; text-align: center;">
    <h1 style="font-size: 3rem; margin-bottom: 1rem; margin-top: 0;">Discover Premium Gear</h1>
    <p style="font-size: 1.25rem; color: #94a3b8; max-width: 600px; margin: 0 auto;">Shop our latest drops running natively without lag.</p>
</div>

<h2 style="font-size: 1.75rem; color: #1e293b; margin-bottom: 2rem;">Featured Products</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
    <?php if (empty($products)): ?>
        <p>No products available yet.</p>
    <?php else: ?>
        <?php foreach ($products as $p): ?>
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;">
                <a href="/product/<?= htmlspecialchars($p['slug'], ENT_QUOTES) ?>" style="text-decoration: none; color: inherit; display: block;">
                    <div style="height: 250px; background: #f8fafc; display: flex; align-items: center; justify-content: center; position: relative;">
                        <?php if(!empty($p['image'])): ?>
                            <img src="/uploads/products/<?= htmlspecialchars($p['image'], ENT_QUOTES) ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Product">
                        <?php else: ?>
                            <span style="color: #94a3b8;">No Image</span>
                        <?php endif; ?>
                    </div>
                    <div style="padding: 1.5rem;">
                        <h3 style="margin: 0 0 0.5rem 0; font-size: 1.15rem; color: #0f172a;"><?= htmlspecialchars($p['title'], ENT_QUOTES) ?></h3>
                        <p style="margin: 0; font-weight: 600; color: #4f46e5; font-size: 1.25rem;">$<?= number_format((float)$p['price'], 2) ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
