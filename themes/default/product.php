<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; margin-top: 2rem;">
    <!-- Image Side -->
    <div style="background: #f8fafc; border-radius: 16px; overflow: hidden; display: flex; align-items: center; justify-content: center; min-height: 500px;">
        <?php if(!empty($product['image'])): ?>
            <img src="/uploads/products/<?= htmlspecialchars($product['image'], ENT_QUOTES) ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Product">
        <?php else: ?>
            <span style="color: #94a3b8;">Image Unavailable</span>
        <?php endif; ?>
    </div>

    <!-- Data Side -->
    <div style="display: flex; flex-direction: column; justify-content: center;">
        <h1 style="font-size: 2.5rem; color: #0f172a; margin: 0 0 1rem 0;"><?= htmlspecialchars($product['title'], ENT_QUOTES) ?></h1>
        <p style="font-size: 2rem; font-weight: 700; color: #4f46e5; margin: 0 0 2rem 0;">$<?= number_format((float)$product['price'], 2) ?></p>
        
        <p style="color: #64748b; line-height: 1.7; margin-bottom: 3rem; font-size: 1.1rem;">
            This is a dynamically parsed product loaded flawlessly via our Native Core ecosystem. Clean URLs ensure rapid SEO indexing.
        </p>

        <form action="/cart/add" method="POST" style="display: flex; gap: 1rem;">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id'], ENT_QUOTES) ?>">
            <input type="number" name="quantity" value="1" min="1" style="width: 80px; padding: 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1.1rem; text-align: center;">
            <button type="submit" style="flex: 1; padding: 1rem 2rem; background: #0f172a; color: white; font-weight: 600; border: none; border-radius: 8px; font-size: 1.1rem; cursor: pointer; transition: background 0.2s;">Add to Cart</button>
        </form>
    </div>
</div>
