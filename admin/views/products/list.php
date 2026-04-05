<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 class="page-title" style="margin: 0;">Products</h2>
    <a href="/admin/products/create" style="padding: 0.75rem 1.5rem; background: var(--primary); color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600;">+ Add Product</a>
</div>

<div class="card" style="padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: #64748b;">Title</th>
                <th style="padding: 1rem 1.5rem; color: #64748b;">Price</th>
                <th style="padding: 1rem 1.5rem; color: #64748b;">Status</th>
                <th style="padding: 1rem 1.5rem; color: #64748b; text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #94a3b8;">No products found. Start by adding one!</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 1rem 1.5rem; font-weight: 500;">
                        <?php if(!empty($p['image'])): ?>
                            <img src="/uploads/products/<?= htmlspecialchars($p['image'], ENT_QUOTES) ?>" alt="img" style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover; vertical-align: middle; margin-right: 1rem;">
                        <?php endif; ?>
                        <?= htmlspecialchars($p['title'], ENT_QUOTES) ?>
                    </td>
                    <td style="padding: 1rem 1.5rem;">$<?= number_format((float)$p['price'], 2) ?></td>
                    <td style="padding: 1rem 1.5rem;"><span style="padding: 0.25rem 0.75rem; background: #e0e7ff; color: #4338ca; border-radius: 20px; font-size: 0.85rem; font-weight: 600;"><?= htmlspecialchars($p['status'] ?? 'published', ENT_QUOTES) ?></span></td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <a href="/admin/products/delete?id=<?= $p['id'] ?>" style="color: #ef4444; text-decoration: none; font-size: 0.9rem;" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
