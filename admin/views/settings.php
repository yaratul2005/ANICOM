<style>
    .settings-layout { display: flex; gap: 2rem; align-items: flex-start; }
    @media (max-width: 900px) { .settings-layout { flex-direction: column; } }

    .tabs-nav {
        width: 250px; flex-shrink: 0; display: flex; flex-direction: column; gap: 0.5rem;
        background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px;
        padding: 1rem; position: sticky; top: 100px;
    }
    .tabs-nav::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 16px; pointer-events: none; opacity: 0.15; }
    
    .tab-btn {
        padding: 0.85rem 1rem; text-align: left; background: none; border: none; cursor: pointer;
        font-family: var(--font-main); font-size: 0.95rem; font-weight: 700; color: var(--m-muted);
        border-radius: 12px; transition: all 0.3s; display: flex; align-items: center; gap: 0.75rem;
        position: relative; z-index: 2;
    }
    .tab-btn svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; }
    .tab-btn:hover { color: var(--m-cyan); background: rgba(6,182,212,0.05); }
    .tab-btn.active { color: #fff; background: var(--gradient-magic); box-shadow: 0 4px 15px rgba(217,70,239,0.3); }

    .tab-content { display: none; flex: 1; min-width: 0; animation: fade-slide 0.4s ease forwards; }
    .tab-content.active { display: block; }

    @keyframes fade-slide {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-panel {
        background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px;
        padding: 2.5rem; position: relative;
    }
    .form-panel::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 16px; pointer-events: none; opacity: 0.2; }
    
    .panel-title { font-size: 1.25rem; font-weight: 900; color: #fff; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px dashed rgba(255,255,255,0.1); position: relative; z-index: 2; display: flex; align-items: center; gap: 0.5rem; }
    .panel-title svg { stroke: var(--m-pink); width: 22px; height: 22px; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; position: relative; z-index: 2; }
    .form-grid.full { grid-template-columns: 1fr; }
    .form-group { display: flex; flex-direction: column; gap: 0.5rem; }
    
    label { font-size: 0.8rem; font-weight: 800; color: var(--m-muted); text-transform: uppercase; letter-spacing: 1px; }
    .hint { font-size: 0.8rem; color: #475569; font-weight: 500; }
    
    .form-control {
        padding: 0.85rem 1rem; border: 1px solid var(--m-border); border-radius: 12px;
        font-family: var(--font-main); font-size: 1rem; color: #fff;
        background: rgba(0,0,0,0.3); transition: all 0.3s;
    }
    .form-control:focus { outline: none; border-color: var(--m-cyan); background: rgba(0,0,0,0.5); box-shadow: 0 0 0 2px rgba(6,182,212,0.2); }
    
    .btn-save {
        padding: 1rem 2.5rem; background: var(--gradient-magic); color: #fff;
        border: none; border-radius: 16px; font-family: var(--font-main); font-size: 1rem;
        font-weight: 800; cursor: pointer; transition: all 0.3s; margin-top: 2rem; position: relative;
        z-index: 2; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: var(--shadow-glow);
    }
    .btn-save::before { content: ''; position: absolute; inset: 2px; border: 1px dashed rgba(255,255,255,0.4); border-radius: 14px; pointer-events: none; }
    .btn-save:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(139,92,246,0.4); animation: stitch-glow 1.5s infinite alternate; }

    .alert { padding: 1rem 1.25rem; border-radius: 14px; margin-bottom: 2rem; font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem; position: relative; z-index: 2; }
    .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #34d399; }
</style>

<div class="top-bar">
    <div class="page-title">
        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        Core Configuration
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <svg style="width:20px;height:20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        Configuration permanently etched into the cosmic database.
    </div>
<?php endif; ?>

<form method="POST" action="/admin/settings" class="settings-layout">
    <div class="tabs-nav">
        <button type="button" class="tab-btn active" onclick="switchTab('general')">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
            General Logistics
        </button>
        <button type="button" class="tab-btn" onclick="switchTab('appearance')">
            <svg viewBox="0 0 24 24"><polygon points="12 2 2 22 12 17 22 22 12 2"></polygon></svg>
            Atmosphere
        </button>
        <button type="button" class="tab-btn" onclick="switchTab('email')">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            Comms (Email)
        </button>
        <button type="button" class="tab-btn" onclick="switchTab('analytics')">
            <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            Deep Analytics & Pixels
        </button>
    </div>

    <div class="tab-content active" id="tab-general">
        <div class="form-panel">
            <div class="panel-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg> General Parameters</div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Realm Name (Store Name)</label>
                    <input type="text" name="store_name" class="form-control" value="<?= htmlspecialchars($settings['store_name'] ?? '') ?>" required>
                    <div class="hint">Your presence across the multiverse.</div>
                </div>
                <div class="form-group">
                    <label>Base Coordinates (Store URL)</label>
                    <input type="url" name="store_url" class="form-control" value="<?= htmlspecialchars($settings['store_url'] ?? '') ?>" required>
                    <div class="hint">Fully qualified domain name (e.g., https://yourrealm.com)</div>
                </div>
                <div class="form-group">
                    <label>Trading Currency</label>
                    <select name="currency" class="form-control">
                        <option value="USD" <?= ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' ?>>USD ($)</option>
                        <option value="EUR" <?= ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' ?>>EUR (€)</option>
                        <option value="GBP" <?= ($settings['currency'] ?? '') == 'GBP' ? 'selected' : '' ?>>GBP (£)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Temporal Zone</label>
                    <select name="timezone" class="form-control">
                        <option value="UTC" <?= ($settings['timezone'] ?? '') == 'UTC' ? 'selected' : '' ?>>UTC</option>
                        <option value="America/New_York" <?= ($settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' ?>>EST / EDT</option>
                        <option value="Europe/London" <?= ($settings['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' ?>>GMT / BST</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-save">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Synchronize Configuration
            </button>
        </div>
    </div>

    <div class="tab-content" id="tab-appearance">
        <div class="form-panel">
            <div class="panel-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg> Atmospheric Styling</div>
            <div class="form-grid full">
                <div class="form-group">
                    <label>Active Theme Cloak</label>
                    <select name="active_theme" class="form-control">
                        <option value="default" <?= ($settings['active_theme'] ?? '') == 'default' ? 'selected' : '' ?>>Stitch & Magic (Default)</option>
                        <!-- Add themes dynamically from /themes/ dir later -->
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-save">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Synchronize Configuration
            </button>
        </div>
    </div>

    <div class="tab-content" id="tab-email">
        <div class="form-panel">
            <div class="panel-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="Mm22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg> Subspace Communications</div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Transmitter Type (Mail Driver)</label>
                    <select name="mail_driver" class="form-control">
                        <option value="mail" <?= ($settings['mail_driver'] ?? '') == 'mail' ? 'selected' : '' ?>>PHP Native Mail()</option>
                        <option value="smtp" <?= ($settings['mail_driver'] ?? '') == 'smtp' ? 'selected' : '' ?>>SMTP Relay</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sender Frequency (From Address)</label>
                    <input type="email" name="mail_from_address" class="form-control" value="<?= htmlspecialchars($settings['mail_from_address'] ?? 'noreply@yourstore.com') ?>">
                </div>
            </div>
            <button type="submit" class="btn-save">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Synchronize Configuration
            </button>
        </div>
    </div>
    <div class="tab-content" id="tab-analytics">
        <div class="form-panel">
            <div class="panel-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg> Global Tracker Scripts (Shopify Killer)</div>
            <p style="color: var(--m-muted); font-size: 0.9rem; margin-top: -1rem; margin-bottom: 2rem;">Paste external scripts (Google Analytics, Meta Pixel, TikTok, etc.) securely without editing themes.</p>
            
            <div class="form-grid full">
                <div class="form-group">
                    <label>Global SEO Meta Description</label>
                    <textarea name="global_meta_desc" class="form-control" style="height: 80px;"><?= htmlspecialchars($settings['global_meta_desc'] ?? '') ?></textarea>
                </div>
                <div class="form-group" style="margin-top: 1rem;">
                    <label>&lt;HEAD&gt; Injection Scripts (e.g. Google Analytics / Meta Pixel base)</label>
                    <textarea name="head_pixel" class="form-control" style="min-height: 150px; font-family: monospace; font-size: 0.8rem;"><?= htmlspecialchars($settings['head_pixel'] ?? '') ?></textarea>
                </div>
                <div class="form-group" style="margin-top: 1rem;">
                    <label>&lt;BODY&gt; Injection Scripts (e.g. GTM NoScript / Chatbots)</label>
                    <textarea name="body_pixel" class="form-control" style="min-height: 150px; font-family: monospace; font-size: 0.8rem;"><?= htmlspecialchars($settings['body_pixel'] ?? '') ?></textarea>
                </div>
            </div>
            <button type="submit" class="btn-save">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Synchronize Configuration
            </button>
        </div>
    </div>
</form>

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content, .tab-btn').forEach(el => el.classList.remove('active'));
        document.getElementById('tab-' + tabId).classList.add('active');
        event.currentTarget.classList.add('active');
    }
</script>
