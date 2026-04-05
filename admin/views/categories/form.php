<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 class="page-title" style="margin: 0;">Add Category</h2>
    <a href="/admin/categories" style="color: #64748b; text-decoration: none; font-weight: 500;">Back to List</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="/admin/categories/create" method="POST">
        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Category Title</label>
            <input type="text" name="title" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
        </div>

        <button type="submit" style="padding: 0.75rem 2rem; background: var(--primary); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Save Category</button>
    </form>
</div>
