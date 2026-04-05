<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 class="page-title" style="margin: 0;">Add Product</h2>
    <a href="/admin/products" style="color: #64748b; text-decoration: none; font-weight: 500;">Back to List</a>
</div>

<div class="card" style="max-width: 800px;">
    <form action="/admin/products/create" method="POST" enctype="multipart/form-data">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Product Title</label>
            <input type="text" name="title" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Price</label>
                <input type="number" step="0.01" name="price" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Status</label>
                <select name="status" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Product Image (Auto-WebP)</label>
            <input type="file" name="image" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px dashed #94a3b8; border-radius: 6px; box-sizing: border-box; background: #f8fafc;">
        </div>

        <button type="submit" style="padding: 0.75rem 2rem; background: var(--primary); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Save Product</button>
    </form>
</div>
