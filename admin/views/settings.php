<style>
    .settings-tabs { display: flex; gap: 0.5rem; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0; }
    .tab-btn { padding: 0.65rem 1.25rem; border: none; background: none; cursor: pointer; font-family: 'Outfit', sans-serif; font-size: 0.9rem; font-weight: 600; color: #64748b; border-bottom: 2px solid transparent; margin-bottom: -2px; border-radius: 6px 6px 0 0; transition: all 0.2s; }
    .tab-btn.active, .tab-btn:hover { color: #6366f1; border-bottom-color: #6366f1; background: #f5f3ff; }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    @media (max-width: 700px) { .form-grid { grid-template-columns: 1fr; } }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .form-group.full { grid-column: 1 / -1; }
    label { font-size: 0.82rem; font-weight: 600; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-family: 'Outfit', sans-serif; font-size: 0.95rem; color: #1e293b; transition: border-color 0.2s, box-shadow 0.2s; background: #fff; width: 100%; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); }
    select.form-control { cursor: pointer; }

    .btn-save { padding: 0.85rem 2rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border: none; border-radius: 10px; font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.35); }

    .alert-success { background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 1rem 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; font-weight: 500; display: flex; align-items: center; gap: 0.75rem; }

    .theme-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
    .theme-card { border: 2px solid #e2e8f0; border-radius: 12px; padding: 1.25rem 1rem; text-align: center; cursor: pointer; transition: all 0.2s; }
    .theme-card:hover { border-color: #c4b5fd; background: #f5f3ff; }
    .theme-card.selected { border-color: #6366f1; background: #ede9fe; }
    .theme-card input[type=radio] { display: none; }
    .theme-name { font-weight: 600; color: #1e293b; margin-top: 0.5rem; font-size: 0.9rem; }
    .theme-icon { font-size: 2rem; }

    .smtp-note { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1rem 1.5rem; color: #64748b; font-size: 0.88rem; line-height: 1.7; }
    .smtp-note code { background: #e2e8f0; padding: 0.1rem 0.4rem; border-radius: 4px; font-size: 0.85rem; color: #334155; }
</style>

<h2 class="page-title">Settings</h2>

<?php if (isset($_GET['saved'])): ?>
<div class="alert-success">✅ Settings saved successfully!</div>
<?php endif; ?>

<div class="settings-tabs">
    <button class="tab-btn active" onclick="switchTab('general', this)">General</button>
    <button class="tab-btn" onclick="switchTab('appearance', this)">Appearance</button>
    <button class="tab-btn" onclick="switchTab('email', this)">Email</button>
</div>

<form method="POST" action="/admin/settings">

    <!-- General Tab -->
    <div class="tab-panel active" id="tab-general">
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="form-grid">
                <div class="form-group">
                    <label for="store_name">Store Name</label>
                    <input id="store_name" type="text" name="store_name" class="form-control" value="<?= htmlspecialchars($settings['store_name'] ?? '') ?>" placeholder="My Amazing Store">
                </div>
                <div class="form-group">
                    <label for="store_url">Store URL</label>
                    <input id="store_url" type="url" name="store_url" class="form-control" value="<?= htmlspecialchars($settings['store_url'] ?? '') ?>" placeholder="https://mystore.com">
                </div>
                <div class="form-group">
                    <label for="store_email">Store Email</label>
                    <input id="store_email" type="email" name="store_email" class="form-control" value="<?= htmlspecialchars($settings['store_email'] ?? '') ?>" placeholder="hello@mystore.com">
                </div>
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <select id="currency" name="currency" class="form-control">
                        <?php foreach (['USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'JPY' => 'JPY (¥)', 'BDT' => 'BDT (৳)'] as $code => $label): ?>
                        <option value="<?= $code ?>" <?= ($settings['currency'] ?? 'USD') === $code ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="timezone">Timezone</label>
                    <select id="timezone" name="timezone" class="form-control">
                        <?php foreach (['UTC', 'Asia/Dhaka', 'Asia/Kolkata', 'America/New_York', 'America/Los_Angeles', 'Europe/London', 'Europe/Paris'] as $tz): ?>
                        <option value="<?= $tz ?>" <?= ($settings['timezone'] ?? 'UTC') === $tz ? 'selected' : '' ?>><?= $tz ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Appearance Tab -->
    <div class="tab-panel" id="tab-appearance">
        <div class="card" style="margin-bottom: 1.5rem;">
            <p style="color: #64748b; margin: 0 0 1.25rem 0; font-size: 0.9rem;">Select the active storefront theme. Place new themes inside the <code style="background:#f1f5f9;padding:0.1rem 0.4rem;border-radius:4px;">/themes/</code> directory.</p>
            <div class="theme-grid">
                <?php foreach ($themes as $theme):
                    $isSelected = ($settings['active_theme'] ?? 'default') === $theme; ?>
                <label class="theme-card <?= $isSelected ? 'selected' : '' ?>">
                    <input type="radio" name="active_theme" value="<?= htmlspecialchars($theme) ?>" <?= $isSelected ? 'checked' : '' ?> onchange="this.closest('.theme-grid').querySelectorAll('.theme-card').forEach(c=>c.classList.remove('selected')); this.closest('.theme-card').classList.add('selected')">
                    <div class="theme-icon">🎨</div>
                    <div class="theme-name"><?= htmlspecialchars(ucfirst($theme)) ?></div>
                </label>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Email Tab -->
    <div class="tab-panel" id="tab-email">
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="smtp-note">
                <strong>📧 Email Configuration</strong><br><br>
                ANICOM uses your server's native PHP <code>mail()</code> function by default.
                To configure SMTP (e.g. Mailtrap, Mailgun, SendGrid), edit the following keys in your <code>.env</code> file:<br><br>
                <code>MAIL_DRIVER</code> · <code>MAIL_HOST</code> · <code>MAIL_PORT</code> · <code>MAIL_USERNAME</code> · <code>MAIL_PASSWORD</code> · <code>MAIL_FROM_ADDRESS</code>
                <br><br>
                After saving the SMTP driver, all transactional emails (order confirmations, account registrations) will route through your specified server automatically.
            </div>
        </div>
    </div>

    <div style="padding-top: 0.5rem;">
        <button type="submit" class="btn-save">💾 Save Settings</button>
    </div>
</form>

<script>
function switchTab(tabId, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + tabId).classList.add('active');
    btn.classList.add('active');
}
</script>
