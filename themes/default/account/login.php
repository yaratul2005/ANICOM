<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'My Account') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .auth-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 3rem; width: 100%; max-width: 440px; box-shadow: 0 25px 60px rgba(0,0,0,0.4); }
        .auth-logo { text-align: center; margin-bottom: 2rem; }
        .auth-logo h1 { font-size: 2rem; font-weight: 800; background: linear-gradient(90deg, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -1px; }
        .auth-logo p { color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-top: 0.4rem; }
        h2 { color: #fff; font-size: 1.5rem; font-weight: 700; margin-bottom: 1.75rem; text-align: center; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.78rem; font-weight: 600; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 0.5rem; }
        input { width: 100%; padding: 0.85rem 1.1rem; background: rgba(255,255,255,0.07); border: 1.5px solid rgba(255,255,255,0.12); border-radius: 12px; color: #fff; font-family: 'Inter', sans-serif; font-size: 0.95rem; transition: all 0.2s; }
        input::placeholder { color: rgba(255,255,255,0.25); }
        input:focus { outline: none; border-color: #818cf8; background: rgba(129,140,248,0.1); box-shadow: 0 0 0 3px rgba(129,140,248,0.15); }
        .btn-auth { width: 100%; padding: 0.95rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border: none; border-radius: 12px; font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all 0.25s; margin-top: 0.75rem; letter-spacing: 0.3px; }
        .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(99,102,241,0.4); }
        .auth-footer { text-align: center; margin-top: 1.75rem; color: rgba(255,255,255,0.4); font-size: 0.88rem; }
        .auth-footer a { color: #818cf8; text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { color: #c084fc; }
        .alert-error { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; padding: 0.85rem 1.1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.88rem; font-weight: 500; }
        .divider { display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0; color: rgba(255,255,255,0.2); font-size: 0.8rem; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.1); }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <h1>ANICOM</h1>
        <p>Your premium shopping destination</p>
    </div>
    <h2>Sign In</h2>

    <?php if (!empty($error)): ?>
    <div class="alert-error">⚠ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/account/login">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" placeholder="you@example.com" required autocomplete="email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn-auth">Sign In →</button>
    </form>

    <div class="divider">or</div>

    <div class="auth-footer">
        Don't have an account? <a href="/account/register">Create one →</a>
    </div>
    <div class="auth-footer" style="margin-top: 0.75rem;">
        <a href="/">← Return to Store</a>
    </div>
</div>
</body>
</html>
