<?php
// Premium Admin Layout
// Enforcing glassmorphism, vibrant interactions, and modern typography
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Dashboard', ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0f172a;
            --sidebar-bg: rgba(15, 23, 42, 0.85);
            --content-bg: #f8fafc;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: #ffffff;
            --border: #e2e8f0;
        }

        body {
            margin: 0; font-family: 'Outfit', sans-serif;
            display: flex; min-height: 100vh; background: var(--bg-color);
            color: #1e293b; overflow-x: hidden;
        }

        /* Abstract dynamic background */
        .bg-shapes {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; overflow: hidden;
            background: #0f172a;
        }
        .shape-1 {
            position: absolute; width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, rgba(99,102,241,0) 70%);
            top: -200px; left: -100px; animation: float 15s ease-in-out infinite alternate;
        }
        .shape-2 {
            position: absolute; width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(236,72,153,0.15) 0%, rgba(236,72,153,0) 70%);
            bottom: -150px; right: -50px; animation: float 12s ease-in-out infinite alternate-reverse;
        }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            100% { transform: translateY(30px) scale(1.05); }
        }

        /* Sidebar - Glassmorphism */
        aside {
            width: 260px; background: var(--sidebar-bg); backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px); border-right: 1px solid rgba(255,255,255,0.1);
            display: flex; flex-direction: column; padding: 2rem 1rem; color: var(--text-main);
            box-shadow: 4px 0 24px rgba(0,0,0,0.2); z-index: 10;
        }

        .brand {
            font-size: 1.5rem; font-weight: 700; margin-bottom: 3rem; padding-left: 1rem;
            background: linear-gradient(90deg, #818cf8, #c084fc);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        nav ul { list-style: none; padding: 0; margin: 0; }
        nav li { margin-bottom: 0.5rem; }
        nav a {
            display: flex; align-items: center; padding: 0.85rem 1rem; color: var(--text-muted);
            text-decoration: none; border-radius: 8px; font-size: 0.95rem; font-weight: 500;
            transition: all 0.3s ease; border: 1px solid transparent;
        }
        nav a:hover, nav a.active {
            background: rgba(255,255,255,0.05); color: #fff;
            border-color: rgba(255,255,255,0.1); transform: translateX(5px);
        }
        nav a i { margin-right: 12px; font-size: 1.1rem; }

        /* Main Content */
        main {
            flex: 1; display: flex; flex-direction: column;
            background: var(--content-bg); border-radius: 24px 0 0 24px;
            margin: 1rem 0 1rem 0; box-shadow: -10px 0 30px rgba(0,0,0,0.5);
            overflow: hidden; z-index: 5;
        }

        header.topbar {
            background: rgba(255,255,255,0.8); backdrop-filter: blur(12px);
            padding: 1.5rem 3rem; display: flex; justify-content: space-between;
            align-items: center; border-bottom: 1px solid var(--border);
        }

        .user-menu {
            display: flex; align-items: center; gap: 1rem; font-weight: 500;
        }
        .logout-btn {
            padding: 0.5rem 1.25rem; background: #fee2e2; color: #ef4444; text-decoration: none;
            border-radius: 20px; font-size: 0.85rem; font-weight: 600; transition: background 0.2s;
        }
        .logout-btn:hover { background: #fecaca; }

        .content-area { padding: 3rem; overflow-y: auto; flex: 1; }
        
        .page-title { margin: 0 0 2rem 0; font-size: 2rem; font-weight: 700; color: #0f172a; letter-spacing: -0.5px; }

        /* Widgets */
        .card {
            background: var(--card-bg); border-radius: 16px; padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            border: 1px solid var(--border); transition: transform 0.3s ease, box-shadow 0.3s;
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="bg-shapes">
        <div class="shape-1"></div>
        <div class="shape-2"></div>
    </div>

    <aside>
        <?php
        $currentUri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
        function navActive(string $path): string {
            global $currentUri;
            if ($path === '/admin/' || $path === '/admin') {
                return ($currentUri === '/admin' || $currentUri === '/admin/') ? 'active' : '';
            }
            return strpos($currentUri, $path) === 0 ? 'active' : '';
        }
        ?>
        <div class="brand">ANICOM Core</div>
        <nav>
            <ul>
                <li><a href="/admin/" class="<?= navActive('/admin/') ?>"><i>▦</i> Dashboard</a></li>
                <li><a href="/admin/products" class="<?= navActive('/admin/products') ?>"><i>📦</i> Products</a></li>
                <li><a href="/admin/categories" class="<?= navActive('/admin/categories') ?>"><i>🏷</i> Categories</a></li>
                <li><a href="/admin/orders" class="<?= navActive('/admin/orders') ?>"><i>🛒</i> Orders</a></li>
                <li><a href="/admin/coupons" class="<?= navActive('/admin/coupons') ?>"><i>🎟</i> Coupons</a></li>
                <li style="margin-top: 1.5rem;"><a href="/admin/settings" class="<?= navActive('/admin/settings') ?>"><i>⚙</i> Settings</a></li>
                <li style="margin-top: 0.5rem;"><a href="/" target="_blank" style="color: #60a5fa;"><i>↗</i> View Storefront</a></li>
            </ul>
        </nav>
    </aside>

    <main>
        <header class="topbar">
            <div><!-- Breadcrumbs or static title --></div>
            <div class="user-menu">
                <span>Welcome, <?= htmlspecialchars(\Core\Auth::user()['name'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></span>
                <a href="/admin/logout" class="logout-btn">Log out</a>
            </div>
        </header>

        <div class="content-area">
            <?= $content ?? '' ?>
        </div>
    </main>
</body>
</html>
