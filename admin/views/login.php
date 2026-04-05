<?php
// Minimalist, premium login view
// Enforces pure aesthetic via plain CSS (No Tailwind)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Login', ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-dark: #111827;
            --text-light: #6b7280;
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --danger: #ef4444;
            --border: #d1d5db;
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-sizing: border-box;
        }

        h2 { margin: 0 0 0.5rem 0; font-size: 1.75rem; font-weight: 700; color: #1f2937; }
        p.subtitle { margin: 0 0 2rem 0; color: var(--text-light); font-size: 0.95rem; }
        .form-group { margin-bottom: 1.5rem; }
        
        label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; color: #374151; }

        input[type="email"], input[type="password"] {
            width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border);
            border-radius: 6px; box-sizing: border-box; font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        button {
            width: 100%; padding: 0.75rem 1rem; background: var(--primary); color: white;
            border: none; border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
        }

        button:hover { background: var(--primary-hover); }
        button:active { transform: scale(0.98); }

        .error {
            background: #fef2f2; color: var(--danger); padding: 0.75rem; border-radius: 6px;
            margin-bottom: 1.5rem; font-size: 0.9rem; border: 1px solid #fecaca;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Welcome Back</h2>
        <p class="subtitle">Access the ANICOM Configuration Backoffice</p>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="POST" action="/admin/login">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required autofocus placeholder="admin@example.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit">Sign In to Dashboard</button>
        </form>
    </div>

</body>
</html>
