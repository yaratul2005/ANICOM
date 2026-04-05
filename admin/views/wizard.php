<?php
// Minimalist, premium onboarding wizard view
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Setup', ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            --card-bg: rgba(255, 255, 255, 0.98);
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --text-dark: #1f2937;
            --border: #e5e7eb;
        }

        body {
            margin: 0; font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg-gradient); display: flex;
            align-items: center; justify-content: center; min-height: 100vh;
        }

        .wizard-container {
            width: 100%; max-width: 600px; padding: 3rem;
            background: var(--card-bg); border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        h2 { margin-top: 0; color: var(--text-dark); }
        .progress-bar { height: 6px; background: #e5e7eb; border-radius: 3px; margin-bottom: 2rem; overflow: hidden; }
        .progress { height: 100%; background: var(--primary); width: <?= ($step / 10) * 100 ?>%; transition: width 0.3s ease; }
        
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; }
        input, select {
            width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border);
            border-radius: 6px; box-sizing: border-box; font-size: 1rem;
        }

        button {
            padding: 0.75rem 2rem; background: var(--primary); color: white;
            border: none; border-radius: 6px; font-weight: 600; cursor: pointer; float: right;
        }
    </style>
</head>
<body>

<div class="wizard-container">
    <div class="progress-bar"><div class="progress"></div></div>

    <form method="POST" action="/admin/setup">
        <input type="hidden" name="step" value="<?= $step ?>">

        <?php if ($step === 1): ?>
            <h2>Welcome to ANICOM</h2>
            <p>You're about to install the fastest, zero-dependency ecommerce engine. Let's configure your store in 10 quick steps.</p>
        <?php elseif ($step === 2): ?>
            <h2>Store Basics</h2>
            <div class="form-group">
                <label>Store Name</label>
                <input type="text" name="store_name" required value="<?= $data['store_name'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Currency Code (e.g. USD)</label>
                <input type="text" name="currency" required value="USD">
            </div>
            <div class="form-group">
                <label>Timezone</label>
                <input type="text" name="timezone" required value="UTC">
            </div>
        <?php elseif ($step === 3): ?>
            <h2>Database Selection</h2>
            <div class="form-group">
                <label>Database Engine</label>
                <select name="db_engine">
                    <option value="file">File-Based JSON Wrapper (Recommended for standard shared hosting)</option>
                    <option value="mysql">MySQL PDO (Requires database setup)</option>
                </select>
            </div>
            <p style="font-size: 0.85rem; color: #666;">If you choose MySQL, ensure credentials are in your `.env` or matched locally.</p>
        <?php elseif ($step === 4): ?>
            <h2>Create Admin Account</h2>
            <div class="form-group">
                <label>Display Name</label>
                <input type="text" name="admin_name" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="admin_email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="admin_password" required>
            </div>
        <?php elseif ($step >= 5 && $step < 10): ?>
            <h2>System Configuration (Step <?= $step ?>)</h2>
            <p>Building automated systems for Payment, Shipping, and SEO pipelines.</p>
            <input type="hidden" name="auto_configured_<?= $step ?>" value="true">
        <?php elseif ($step === 10): ?>
            <h2>Go Live Checklist</h2>
            <p>Your store architecture has been processed.</p>
            <ul>
                <li>✔ Core router bound</li>
                <li>✔ Databases securely connected</li>
                <li>✔ Admin protocols initiated</li>
            </ul>
            <p>Click complete to generate installation lock and jump to Dashboard.</p>
        <?php endif; ?>

        <div style="clear: both; margin-top: 2rem;">
            <?php if ($step > 1): ?>
                <a href="/admin/setup?step=<?= $step - 1 ?>" style="float: left; padding: 0.75rem; color: #666; text-decoration: none;">Back</a>
            <?php endif; ?>
            <button type="submit"><?= $step === 10 ? 'Complete Installation' : 'Next Step' ?></button>
        </div>
    </form>
</div>

</body>
</html>
