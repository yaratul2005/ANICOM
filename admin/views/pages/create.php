<style>
    .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
    .page-title { font-size: 1.8rem; font-weight: 900; color: #fff; display: flex; align-items: center; gap: 0.6rem; }
    .page-title svg { stroke: var(--m-pink); width: 28px; height: 28px; }
    
    .btn-back { display: inline-flex; align-items: center; gap: 0.5rem; color: var(--m-muted); text-decoration: none; font-weight: 700; font-size: 0.95rem; transition: color 0.2s; }
    .btn-back:hover { color: var(--m-cyan); }
    .btn-back svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; }

    .form-panel { background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px; padding: 2.5rem; position: relative; }
    .form-panel::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 16px; pointer-events: none; opacity: 0.2; }
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; position: relative; z-index: 2; }
    .form-grid.full { grid-template-columns: 1fr; }
    .form-group { display: flex; flex-direction: column; gap: 0.5rem; }
    
    label { font-size: 0.8rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 0.4rem; }
    .hint { font-size: 0.8rem; color: #475569; font-weight: 500; }
    
    .form-control {
        padding: 0.85rem 1rem; border: 1px solid var(--m-border); border-radius: 12px;
        font-family: var(--font-main); font-size: 1rem; color: #fff;
        background: rgba(0,0,0,0.3); transition: all 0.3s;
    }
    .form-control:focus { outline: none; border-color: var(--m-cyan); background: rgba(0,0,0,0.5); box-shadow: 0 0 0 2px rgba(6,182,212,0.2); }
    
    textarea.form-control { min-height: 350px; font-family: monospace; font-size: 0.9rem; line-height: 1.5; resize: vertical; }

    .btn-submit {
        padding: 1rem 2.5rem; background: var(--gradient-magic); color: #fff;
        border: none; border-radius: 16px; font-family: var(--font-main); font-size: 1rem;
        font-weight: 800; cursor: pointer; transition: all 0.3s; margin-top: 2rem; position: relative;
        z-index: 2; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: var(--shadow-glow);
    }
    .btn-submit::before { content: ''; position: absolute; inset: 2px; border: 1px dashed rgba(255,255,255,0.4); border-radius: 14px; pointer-events: none; }
    .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(139,92,246,0.4); animation: stitch-glow 1.5s infinite alternate; }
</style>

<div class="top-bar">
    <div class="page-title">
        <svg viewBox="0 0 24 24"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
        <?= isset($page) ? 'Recalibrate Dimension' : 'Conjure Dimension' ?>
    </div>
    <a href="/admin/pages" class="btn-back">
        <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Back to Archive
    </a>
</div>

<div class="form-panel">
    <form method="POST" action="/admin/pages/create<?= isset($page) ? '?id='.$page['id'] : '' ?>">
        <div class="form-grid">
            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($page['title'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Slug (URL Matrix)</label>
                <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($page['slug'] ?? '') ?>" placeholder="leave blank to map from title">
            </div>
        </div>

        <div class="form-grid full" style="margin-top: 1.5rem;">
            <div class="form-group">
                <label>SEO Meta Description</label>
                <input type="text" name="meta_desc" class="form-control" value="<?= htmlspecialchars($page['meta_desc'] ?? '') ?>">
            </div>
        </div>

        <div class="form-grid full" style="margin-top: 1.5rem;">
            <div class="form-group">
                <label>HTML Content Fabric</label>
                <textarea name="content" class="form-control"><?= htmlspecialchars($page['content'] ?? '') ?></textarea>
                <div class="hint">The raw energetic code comprising this page. Basic HTML rules apply.</div>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
            <?= isset($page) ? 'Update Architecture' : 'Seal Dimension' ?>
        </button>
    </form>
</div>
