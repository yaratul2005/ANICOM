<style>
    .page-container {
        max-width: 900px; margin: 4rem auto; padding: 3rem; background: var(--m-card);
        border: 1px solid var(--m-border); border-radius: 24px; position: relative;
    }
    .page-container::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 20px; pointer-events: none; opacity: 0.15; }
    
    .page-header { text-align: center; margin-bottom: 3rem; position: relative; z-index: 2; padding-bottom: 2rem; border-bottom: 1px dashed rgba(255,255,255,0.1); }
    .page-title { font-size: 2.5rem; font-weight: 900; background: var(--gradient-magic); -webkit-background-clip: text; color: transparent; margin: 0; }
    
    .page-body { position: relative; z-index: 2; color: #cbd5e1; font-size: 1.05rem; line-height: 1.7; }
    .page-body h1, .page-body h2, .page-body h3 { color: #fff; margin-top: 2rem; font-weight: 800; }
    .page-body a { color: var(--m-cyan); text-decoration: none; font-weight: 700; border-bottom: 1px dashed rgba(6,182,212,0.4); }
    .page-body a:hover { color: var(--m-pink); border-color: rgba(217,70,239,0.4); }
    .page-body ul { padding-left: 1.5rem; }
    .page-body li { margin-bottom: 0.5rem; }
</style>

<div class="page-container">
    <div class="page-header">
        <h1 class="page-title"><?= htmlspecialchars($page['title'] ?? 'Dimensional Rift') ?></h1>
    </div>
    <div class="page-body">
        <?= $page['content'] ?? '<p>This structure lacks atmospheric content.</p>' ?>
    </div>
</div>
