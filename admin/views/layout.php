<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Panel') ?> — ANICOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Cosmic Admin Theme */
            --m-bg: #03050a;
            --m-sidebar: rgba(10, 13, 26, 0.85);
            --m-card: rgba(16, 20, 36, 0.7);
            --m-border: #1e2440;
            --m-text: #e2e8f0;
            --m-muted: #8b98b5;
            
            --m-pink: #d946ef;
            --m-cyan: #06b6d4;
            --m-purple: #8b5cf6;
            --m-blue: #3b82f6;

            --gradient-magic: linear-gradient(135deg, var(--m-blue), var(--m-purple), var(--m-pink));
            --stitch-border: 2px dashed rgba(139, 92, 246, 0.3);
            
            --font-main: 'Outfit', sans-serif;
            --shadow-glow: 0 0 15px rgba(139, 92, 246, 0.2);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-main);
            background: var(--m-bg);
            color: var(--m-text);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient cosmic background */
        body::before {
            content: ''; position: fixed; inset: -20%; width: 140%; height: 140%;
            background: radial-gradient(circle at 10% 20%, rgba(139,92,246,0.1) 0%, transparent 40%),
                        radial-gradient(circle at 90% 80%, rgba(6,182,212,0.1) 0%, transparent 40%);
            z-index: -1; pointer-events: none;
        }

        @keyframes float-badge {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--m-sidebar);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--m-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 100;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                padding: 1.5rem 1rem !important;
            }
        }

        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px);
            z-index: 90; display: none; opacity: 0; transition: opacity 0.3s;
        }
        .sidebar-overlay.open { display: block; opacity: 1; }

        .sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px dashed rgba(255,255,255,0.05);
        }

        .logo-icon {
            width: 32px; height: 32px;
            background: var(--gradient-magic);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 900; font-size: 1.2rem;
            box-shadow: var(--shadow-glow);
            position: relative;
        }
        .logo-icon::after { content: ''; position: absolute; inset: 2px; border: 1px dashed rgba(255,255,255,0.4); border-radius: 6px; }
        
        .logo-text { font-size: 1.25rem; font-weight: 900; color: #fff; letter-spacing: 0.5px; }

        .nav-menu { flex: 1; padding: 1.25rem 1rem; display: flex; flex-direction: column; gap: 0.4rem; overflow-y: auto; }
        .nav-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem 1rem; color: var(--m-muted);
            text-decoration: none; font-weight: 600; font-size: 0.95rem;
            border-radius: 12px; transition: all 0.3s;
            position: relative; border: 1px solid transparent;
        }
        
        .nav-item svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        
        .nav-item:hover { color: var(--m-cyan); background: rgba(6,182,212,0.05); border-color: rgba(6,182,212,0.1); }
        .nav-item.active {
            color: #fff; background: var(--gradient-magic);
            box-shadow: 0 4px 15px rgba(139,92,246,0.3); border-color: transparent;
        }
        .nav-item.active::before { content: ''; position: absolute; inset: 1px; border: 1px dashed rgba(255,255,255,0.3); border-radius: 11px; pointer-events: none; }

        .user-block {
            padding: 1.25rem; border-top: 1px dashed rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: space-between;
        }
        .user-info { display: flex; align-items: center; gap: 0.75rem; }
        .user-avatar { width: 36px; height: 36px; background: rgba(139,92,246,0.2); border: 1px dashed var(--m-purple); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--m-purple); font-weight: 800; font-size: 1.1rem; }
        .user-name { font-size: 0.85rem; font-weight: 700; color: #fff; }
        
        .logout-btn { color: var(--m-muted); transition: color 0.2s; padding: 0.5rem; }
        .logout-btn:hover { color: #f43f5e; }

        /* Main Content */
        .main-content { flex: 1; min-width: 0; padding: 2rem 3rem; animation: fade-in 0.5s ease; margin-left: 260px; transition: margin 0.3s; }
        @media (max-width: 1024px) { .main-content { margin-left: 0; } }

        @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem; }
        
        .mobile-toggle {
            display: none; background: none; border: none; color: #fff; cursor: pointer; padding: 0.5rem;
        }
        .mobile-toggle svg { width: 24px; height: 24px; stroke: currentColor; fill: none; stroke-width: 2; }
        
        @media (max-width: 1024px) {
            .mobile-toggle { display: block; }
            .page-title { font-size: 1.4rem !important; }
            .top-actions { width: 100%; display: flex; justify-content: flex-end; }
        }

        .page-title { font-size: 1.8rem; font-weight: 900; color: #fff; display: flex; align-items: center; gap: 0.6rem; }
        .page-title svg { stroke: var(--m-pink); width: 26px; height: 26px; }
        
        .top-actions { display: flex; align-items: center; gap: 1rem; }
        
        .btn-primary {
            background: var(--gradient-magic); color: #fff; padding: 0.65rem 1.25rem;
            border-radius: 12px; font-weight: 800; text-decoration: none; font-size: 0.9rem;
            display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s;
            position: relative; box-shadow: var(--shadow-glow); border: none; cursor: pointer;
        }
        .btn-primary::before { content: ''; position: absolute; inset: 1px; border: 1px dashed rgba(255,255,255,0.4); border-radius: 11px; pointer-events: none; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(217,70,239,0.4); }

        .btn-outline {
            background: rgba(255,255,255,0.03); border: var(--stitch-border); color: var(--m-text);
            padding: 0.65rem 1.25rem; border-radius: 12px; font-weight: 700; text-decoration: none;
            font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s;
        }
        .btn-outline:hover { background: rgba(6,182,212,0.1); border-color: var(--m-cyan); color: var(--m-cyan); }

        /* Magico Cards */
        .card { background: var(--m-card); border: 1px solid var(--m-border); border-radius: 20px; position: relative; }
        .card::after { content: ''; position: absolute; inset: 4px; border: var(--stitch-border); border-radius: 16px; pointer-events: none; opacity: 0.2; }
    </style>
</head>
<body>

<?php
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true; // N/A, checking role in future implementations
$isAdmin = true; // Forcing display since auth middleware validates access
?>

<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">A</div>
        <div class="logo-text">ANICOM</div>
    </div>
    
    <nav class="nav-menu">
        <a href="/admin" class="nav-item <?= $uri === '/admin' || $uri === '/admin/' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Command Center
        </a>
        <a href="/admin/orders" class="nav-item <?= strpos($uri, '/admin/orders') === 0 ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Order Matrix
        </a>
        <a href="/admin/products" class="nav-item <?= strpos($uri, '/admin/products') === 0 ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            Artifacts
        </a>
        <a href="/admin/categories" class="nav-item <?= strpos($uri, '/admin/categories') === 0 ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            Taxonomies
        </a>
        <a href="/admin/coupons" class="nav-item <?= strpos($uri, '/admin/coupons') === 0 ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            Enchantments
        </a>
        <a href="/admin/settings" class="nav-item <?= strpos($uri, '/admin/settings') === 0 ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
            Core Setup
        </a>
        <a href="/" target="_blank" class="nav-item" style="margin-top:auto;">
            <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            View Realm
        </a>
    </nav>

    <?php if ($isAdmin): ?>
    <div class="user-block">
        <div class="user-info">
            <div class="user-avatar">AD</div>
            <div class="user-name">Grand Architect</div>
        </div>
        <a href="/admin/logout" class="logout-btn" title="Logout">
            <svg style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
        </a>
    </div>
    <?php endif; ?>
</aside>

<main class="main-content">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;" class="mobile-header-wrapper">
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
    </div>
    <?= str_replace('<div class="top-bar">', '<div class="top-bar" style="margin-bottom: 1.5rem;">', $content ?? '') ?>
</main>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
    }
</script>

</body>
</html>
