<style>
    .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
    .page-title { font-size: 1.8rem; font-weight: 900; color: #fff; display: flex; align-items: center; gap: 0.6rem; }
    .page-title svg { stroke: var(--m-cyan); width: 28px; height: 28px; }
    
    .btn-primary {
        background: var(--gradient-magic); color: #fff; padding: 0.65rem 1.25rem;
        border-radius: 12px; font-weight: 800; text-decoration: none; font-size: 0.95rem;
        display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s;
        box-shadow: var(--shadow-glow); border: none; cursor: pointer; position: relative;
    }
    .btn-primary::before { content: ''; position: absolute; inset: 1px; border: 1px dashed rgba(255,255,255,0.4); border-radius: 11px; pointer-events: none; }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(217,70,239,0.4); }

    .panel { background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px; padding: 1.5rem; position: relative; }
    .panel::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 16px; pointer-events: none; opacity: 0.15; }

    table { width: 100%; border-collapse: collapse; position: relative; z-index: 2; }
    th { text-align: left; padding: 1rem; font-size: 0.8rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px dashed rgba(255,255,255,0.05); }
    td { padding: 1rem; border-bottom: 1px dashed rgba(255,255,255,0.05); color: var(--m-text); font-weight: 500; }
    tr:hover td { background: rgba(255,255,255,0.02); }

    .route-slug { display: inline-block; padding: 0.3rem 0.6rem; background: rgba(59,130,246,0.1); border: 1px solid var(--m-blue); color: #60a5fa; border-radius: 8px; font-family: monospace; font-size: 0.85rem; }
    
    .btn-link { color: var(--m-cyan); text-decoration: none; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.3rem; margin-right: 1rem; }
    .btn-delete { color: #f43f5e; text-decoration: none; font-size: 0.85rem; font-weight: 700; transition: color 0.2s; display: inline-flex; align-items: center; gap: 0.3rem; }
    
    .empty-state { text-align: center; padding: 4rem 2rem; color: var(--m-muted); position: relative; z-index: 2; }
    .empty-state svg { width: 48px; height: 48px; stroke: var(--m-border); fill: none; stroke-width: 1.5; margin-bottom: 1rem; }
</style>

<div class="top-bar">
    <div class="page-title">
        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        Dimensional Pages
    </div>
    <a href="/admin/pages/create" class="btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Conjure Page
    </a>
</div>

<div class="panel">
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Routing Slug</th>
                <th>SEO Meta</th>
                <th>Chronology</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pages)): ?>
                <?php foreach ($pages as $page): ?>
                <tr>
                    <td style="font-weight: 800; color: #fff;"><?= htmlspecialchars($page['title']) ?></td>
                    <td><a href="/page/<?= htmlspecialchars($page['slug']) ?>" target="_blank" class="route-slug">/page/<?= htmlspecialchars($page['slug']) ?></a></td>
                    <td style="color: var(--m-muted); font-size: 0.85rem; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?= htmlspecialchars($page['meta_desc'] ?: 'No meta description') ?>
                    </td>
                    <td style="color: var(--m-muted); font-size: 0.9rem;">
                        <?= htmlspecialchars(substr($page['created_at'] ?? 'N/A', 0, 10)) ?>
                    </td>
                    <td>
                        <a href="/admin/pages/create?id=<?= urlencode($page['id']) ?>" class="btn-link">Edit</a>
                        <a href="/admin/pages/delete?id=<?= urlencode($page['id']) ?>" class="btn-delete" onclick="return confirm('Shatter this dimension forever?');">Dispel</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path></svg><br>
                            <span style="font-size: 1.1rem; font-weight: 800; color:#fff;">No pages exist in this realm.</span><br>
                            Conjure a page like "About Us" or "Privacy Policy".
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
