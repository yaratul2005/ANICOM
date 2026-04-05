<style>
    .form-back { display: inline-flex; align-items: center; gap: 0.4rem; color: #6366f1; text-decoration: none; font-weight: 600; font-size: 0.9rem; margin-bottom: 1.5rem; transition: gap 0.2s; }
    .form-back:hover { gap: 0.7rem; }
    .create-form { max-width: 620px; }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1.25rem; }
    label { font-size: 0.82rem; font-weight: 600; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-hint { font-size: 0.78rem; color: #94a3b8; margin-top: 0.2rem; }
    .form-control { padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-family: 'Outfit', sans-serif; font-size: 0.95rem; color: #1e293b; transition: border-color 0.2s, box-shadow 0.2s; background: #fff; width: 100%; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    .type-toggle { display: flex; gap: 0.5rem; }
    .type-option { flex: 1; }
    .type-option input[type=radio] { display: none; }
    .type-option label { display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.65rem; border: 2px solid #e2e8f0; border-radius: 10px; cursor: pointer; color: #64748b; font-size: 0.9rem; font-weight: 600; text-transform: none; letter-spacing: 0; transition: all 0.2s; }
    .type-option input:checked + label { border-color: #6366f1; background: #ede9fe; color: #6366f1; }
    .btn-save { width: 100%; padding: 0.9rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border: none; border-radius: 10px; font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all 0.2s; margin-top: 0.5rem; }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.35); }
    .alert-error { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; font-weight: 500; }
</style>

<a href="/admin/coupons" class="form-back">← Back to Coupons</a>
<h2 class="page-title">Create Coupon</h2>

<?php if (!empty($error)): ?>
<div class="alert-error">⚠ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card create-form">
    <form method="POST" action="/admin/coupons/create">
        <div class="form-group">
            <label for="code">Coupon Code</label>
            <input id="code" type="text" name="code" class="form-control" value="<?= htmlspecialchars($old['code'] ?? '') ?>" placeholder="e.g. SAVE10" style="text-transform: uppercase; letter-spacing: 2px; font-weight: 700;" required>
            <span class="form-hint">The code customers will type at checkout. Auto-uppercased.</span>
        </div>

        <div class="form-group">
            <label>Discount Type</label>
            <div class="type-toggle">
                <div class="type-option">
                    <input type="radio" name="type" id="type-percent" value="percent" <?= ($old['type'] ?? 'percent') === 'percent' ? 'checked' : '' ?>>
                    <label for="type-percent">% Percentage</label>
                </div>
                <div class="type-option">
                    <input type="radio" name="type" id="type-fixed" value="fixed" <?= ($old['type'] ?? '') === 'fixed' ? 'checked' : '' ?>>
                    <label for="type-fixed">$ Fixed Amount</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="value">Discount Value</label>
                <input id="value" type="number" name="value" class="form-control" value="<?= htmlspecialchars($old['value'] ?? '') ?>" step="0.01" min="0.01" placeholder="e.g. 10" required>
                <span class="form-hint">Enter 10 for 10% off or $10 fixed.</span>
            </div>
            <div class="form-group">
                <label for="usage_limit">Usage Limit</label>
                <input id="usage_limit" type="number" name="usage_limit" class="form-control" value="<?= htmlspecialchars($old['usage_limit'] ?? '') ?>" min="1" placeholder="Leave blank for unlimited">
                <span class="form-hint">Max total redemptions.</span>
            </div>
        </div>

        <div class="form-group">
            <label for="expires_at">Expiry Date</label>
            <input id="expires_at" type="date" name="expires_at" class="form-control" value="<?= htmlspecialchars($old['expires_at'] ?? '') ?>">
            <span class="form-hint">Leave blank for no expiry.</span>
        </div>

        <button type="submit" class="btn-save">🏷️ Create Coupon</button>
    </form>
</div>
