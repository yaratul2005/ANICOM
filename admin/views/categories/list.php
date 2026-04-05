<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 class="page-title" style="margin: 0;">Categories</h2>
    <a href="/admin/categories/create" style="padding: 0.75rem 1.5rem; background: var(--primary); color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600;">+ Add Category</a>
</div>

<div class="card" style="padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: #64748b;">Title</th>
                <th style="padding: 1rem 1.5rem; color: #64748b;">Slug</th>
                <th style="padding: 1rem 1.5rem; color: #64748b; text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="3" style="padding: 2rem; text-align: center; color: #94a3b8;">No categories found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories as $c): ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 1rem 1.5rem; font-weight: 500;"><?= htmlspecialchars($c['title'], ENT_QUOTES) ?></td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;"><?= htmlspecialchars($c['slug'], ENT_QUOTES) ?></td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <a href="/admin/categories/delete?id=<?= $c['id'] ?>" style="color: #ef4444; text-decoration: none; font-size: 0.9rem;" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
