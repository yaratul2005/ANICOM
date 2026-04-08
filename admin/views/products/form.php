<style>
    .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
    .page-title { font-size: 1.8rem; font-weight: 900; color: #fff; display: flex; align-items: center; gap: 0.6rem; }
    .page-title svg { stroke: var(--m-cyan); width: 28px; height: 28px; }
    
    .btn-back { display: inline-flex; align-items: center; gap: 0.5rem; color: var(--m-muted); text-decoration: none; font-weight: 700; font-size: 0.95rem; transition: color 0.2s; }
    .btn-back:hover { color: var(--m-pink); }
    
    .form-panel { background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px; padding: 2.5rem; position: relative; }
    .form-panel::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 16px; pointer-events: none; opacity: 0.2; }
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; position: relative; z-index: 2; margin-bottom: 1.5rem; }
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
    textarea.form-control { min-height: 200px; resize: vertical; }

    .file-input-wrapper {
        position: relative; overflow: hidden; display: inline-block;
        background: rgba(0,0,0,0.3); border: 1px dashed var(--m-border); border-radius: 12px; padding: 2rem; text-align: center; cursor: pointer; transition: all 0.3s;
    }
    .file-input-wrapper:hover { border-color: var(--m-cyan); background: rgba(6,182,212,0.05); }
    .file-input-wrapper input[type=file] { position: absolute; left: 0; top: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer; }
    .file-input-label { font-weight: 800; color: var(--m-cyan); font-size: 1rem; }
    .file-input-hint { font-size: 0.85rem; color: var(--m-muted); margin-top: 0.5rem; font-weight: 500; }

    .btn-submit {
        padding: 1rem 2.5rem; background: var(--gradient-magic); color: #fff;
        border: none; border-radius: 16px; font-family: var(--font-main); font-size: 1rem;
        font-weight: 800; cursor: pointer; transition: all 0.3s; position: relative; z-index: 2; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: var(--shadow-glow); margin-top: 1rem;
    }
    .btn-submit::before { content: ''; position: absolute; inset: 2px; border: 1px dashed rgba(255,255,255,0.4); border-radius: 14px; pointer-events: none; }
    .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(139,92,246,0.4); animation: stitch-glow 1.5s infinite alternate; }
</style>

<div class="top-bar">
    <div class="page-title">
        <svg viewBox="0 0 24 24" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Forge Semantic Artifact
    </div>
    <a href="/admin/products" class="btn-back">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Back to Matrix
    </a>
</div>

<div class="form-panel">
    <form action="/admin/products/create" method="POST" enctype="multipart/form-data">
        
        <div class="form-grid full">
            <div class="form-group">
                <label>Artifact Title</label>
                <input type="text" name="title" class="form-control" placeholder="E.g. Nebula Hoodie" required>
            </div>
        </div>

        <div class="form-grid full">
            <div class="form-group">
                <label>Artifact Description</label>
                <textarea name="description" id="description-editor" class="form-control" placeholder="A rich, compelling description of this item..."></textarea>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" required placeholder="0.00">
            </div>
            <div class="form-group">
                <label>Compare At Price (Discounting)</label>
                <input type="number" step="0.01" name="compare_at_price" class="form-control" placeholder="Optional original price.">
                <div class="hint">If higher than Price, the item will show on sale.</div>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Visibility Status</label>
                <select name="status" class="form-control">
                    <option value="published">Published (Live)</option>
                    <option value="draft">Draft (Hidden)</option>
                </select>
            </div>
        </div>

        <div class="form-grid full">
            <div class="form-group">
                <label>Artifact Media Gallery</label>
                <div class="file-input-wrapper">
                    <input type="file" name="media[]" accept="image/*" multiple>
                    <div class="file-input-label">Select Multiple Media Files</div>
                    <div class="file-input-hint">Will automatically be converted to optimized .WebP pipeline.</div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
            Fabricate Product
        </button>
    </form>
</div>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#description-editor',
    height: 300,
    menubar: false,
    plugins: 'lists link image code',
    toolbar: 'bold italic underline | bullist numlist | link image | code',
    skin: 'oxide-dark',
    content_css: 'dark',
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});
</script>
