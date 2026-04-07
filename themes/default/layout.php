<?php
// Load global settings for pixel injection
$storeSettingsFile = __DIR__ . '/../../anicom-data/settings/store.json';
$storeSettings = file_exists($storeSettingsFile) ? json_decode(file_get_contents($storeSettingsFile), true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Storefront', ENT_QUOTES, 'UTF-8') ?></title>

    <?= \Core\SEO::generateMetaTags(
        $title ?? 'Storefront',
        $meta_desc ?? $storeSettings['global_meta_desc'] ?? 'Discover the magic with ANICOM.',
        isset($product['image']) ? '/uploads/products/' . $product['image'] : ''
    ) ?>

    <?= \Core\SEO::generateSchema(isset($product) ? 'Product' : 'Store', ['product' => $product ?? null]) ?>

    <!-- Global Deep Analytics (Head snippet injector) -->
    <?= htmlspecialchars_decode($storeSettings['head_pixel'] ?? '') ?>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --m-bg: #070913;
            --m-card: rgba(22, 26, 45, 0.6);
            --m-border: #2a2e4a;
            --m-text: #e2e8f0;
            --m-muted: #8b98b5;
            
            --m-pink: #d946ef;
            --m-cyan: #06b6d4;
            --m-purple: #8b5cf6;
            --m-blue: #3b82f6;

            --gradient-magic: linear-gradient(135deg, var(--m-blue), var(--m-purple), var(--m-pink));
            --gradient-glow: linear-gradient(135deg, rgba(59,130,246,0.3), rgba(217,70,239,0.3));

            --font-main: 'Outfit', sans-serif;
            --shadow-magic: 0 10px 30px rgba(139, 92, 246, 0.15);
            --shadow-glow: 0 0 20px rgba(6, 182, 212, 0.3);
            
            --stitch-border: 2px dashed rgba(139, 92, 246, 0.4);
            --stitch-border-hover: 2px dashed var(--m-cyan);
        }

        @keyframes magical-float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }

        @keyframes stitch-glow {
            0% { box-shadow: 0 0 10px rgba(139,92,246,0.2); }
            50% { box-shadow: 0 0 25px rgba(217,70,239,0.5); }
            100% { box-shadow: 0 0 10px rgba(139,92,246,0.2); }
        }

        @keyframes magic-slide-up {
            0% { opacity: 0; transform: translateY(20px) scale(0.98); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-main);
            background: var(--m-bg);
            color: var(--m-text);
            line-height: 1.6;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient cosmic background */
        body::before {
            content: ''; position: fixed; top: -20vh; left: -20vw; width: 140vw; height: 140vh;
            background: radial-gradient(circle at 20% 30%, rgba(139,92,246,0.1) 0%, transparent 40%),
                        radial-gradient(circle at 80% 70%, rgba(6,182,212,0.1) 0%, transparent 40%),
                        radial-gradient(circle at 50% 10%, rgba(217,70,239,0.05) 0%, transparent 60%);
            z-index: -1; pointer-events: none;
        }

        /* ========= HEADER ========= */
        .site-header {
            position: sticky; top: 0; z-index: 100;
            background: rgba(7, 9, 19, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--m-border);
            transition: all 0.4s ease;
        }
        .site-header.scrolled {
            box-shadow: 0 5px 30px rgba(0,0,0,0.5);
            border-bottom-color: rgba(139, 92, 246, 0.3);
        }

        .header-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 0 2rem; display: flex; align-items: center; justify-content: space-between;
            height: 80px;
        }

        .logo {
            font-size: 1.8rem; font-weight: 900;
            background: var(--gradient-magic);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px; text-decoration: none;
            position: relative;
        }
        .logo::after {
            content: '✨'; position: absolute; font-size: 1rem; top: -5px; right: -20px;
            animation: magical-float 3s ease-in-out infinite;
        }

        .header-nav { display: flex; align-items: center; gap: 2rem; }
        .header-nav a {
            color: var(--m-text); text-decoration: none; font-weight: 500;
            font-size: 1rem; transition: all 0.3s ease; position: relative;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .header-nav > a:not(.btn):hover {
            color: var(--m-cyan); text-shadow: 0 0 10px rgba(6,182,212,0.5);
        }
        
        .header-icon { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .btn {
            padding: 0.5rem 1.25rem; border-radius: 30px; font-weight: 600;
            text-decoration: none; transition: all 0.3s ease; position: relative;
            display: flex; align-items: center; gap: 0.5rem;
        }
        
        .btn-outline {
            background: rgba(255,255,255,0.03);
            border: var(--stitch-border);
            color: var(--m-text);
        }
        .btn-outline:hover {
            border: var(--stitch-border-hover);
            background: rgba(6,182,212,0.1);
            color: var(--m-cyan);
            transform: translateY(-2px);
        }

        .btn-magic {
            background: var(--gradient-magic);
            color: #fff !important; border: none;
            box-shadow: 0 4px 15px rgba(217,70,239,0.3);
            position: relative; overflow: hidden;
        }
        .btn-magic::before {
            content: ''; position: absolute; top: 1px; left: 1px; right: 1px; bottom: 1px;
            border: 1px dashed rgba(255,255,255,0.5); border-radius: 30px; pointer-events: none;
        }
        .btn-magic:hover {
            transform: translateY(-2px) scale(1.02);
            animation: stitch-glow 1.5s infinite alternate;
        }

        .cart-badge {
            background: #fff; color: var(--m-purple);
            border-radius: 50%; font-size: 0.75rem; font-weight: 800;
            width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 10px rgba(255,255,255,0.5);
        }

        /* ========= MAIN ========= */
        .page-wrap {
            max-width: 1280px; margin: 0 auto;
            padding: 3rem 2rem;
            animation: magic-slide-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* ========= TRUMP CARD STITCHING ========= */
        .card-magico {
            background: var(--m-card);
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--m-border);
            border-radius: 24px; padding: 2rem;
            position: relative; overflow: hidden;
            transition: all 0.4s ease;
        }
        .card-magico::after {
            content: ''; position: absolute; inset: 6px;
            border: var(--stitch-border);
            border-radius: 18px; pointer-events: none;
            transition: border-color 0.4s, opacity 0.4s;
            opacity: 0.3;
        }
        .card-magico:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-magic);
            border-color: rgba(139,92,246,0.5);
        }
        .card-magico:hover::after {
            opacity: 1; border-color: var(--m-cyan);
            animation: magical-float 3s ease-in-out infinite;
        }

        /* ========= FOOTER ========= */
        .site-footer {
            border-top: var(--stitch-border);
            padding: 4rem 2rem; text-align: center; color: var(--m-muted);
            margin-top: 4rem; position: relative; background: rgba(0,0,0,0.2);
        }
        .site-footer strong {
            background: var(--gradient-magic);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
    </style>

    <script>
        window.addEventListener('scroll', () => {
            document.querySelector('.site-header')?.classList.toggle('scrolled', window.scrollY > 20);
        });
    </script>
</head>
<body>

<!-- Global Deep Analytics (Body snippet injector) -->
<?= htmlspecialchars_decode($storeSettings['body_pixel'] ?? '') ?>

<header class="site-header" id="site-header">
    <div class="header-inner">
        <a href="/" class="logo">ANICOM</a>

        <nav class="header-nav">
            <a href="/">
                <svg class="header-icon" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Shop
            </a>
            
            <?php
            $cartCount = array_sum(array_column(\Core\Cart::getItems(), 'quantity'));
            $customer  = \Core\Customer::current();
            if ($customer): ?>
                <a href="/account" class="btn btn-outline" style="border-radius: 12px;">
                    <svg class="header-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?= htmlspecialchars(explode(' ', $customer['name'])[0]) ?>
                </a>
            <?php else: ?>
                <a href="/account/login" class="btn btn-outline" style="border-radius: 12px;">
                    <svg class="header-icon" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                    Sign In
                </a>
            <?php endif; ?>

            <a href="/cart" class="btn btn-magic">
                <svg class="header-icon" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                Cart
                <?php if ($cartCount > 0): ?>
                <span class="cart-badge"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>
        </nav>
    </div>
</header>

<div class="page-wrap">
    <?= $content ?? '' ?>
</div>

<footer class="site-footer">
    <svg style="position:absolute; top:-15px; left:50%; transform:translateX(-50%); width:30px; height:30px; fill:none; stroke:var(--m-purple); stroke-width:2;" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
    <p>&copy; <?= date('Y') ?> <strong>ANICOM</strong>. Woven with magic and code.</p>
    <p style="margin-top: 0.75rem;"><a href="/admin/" style="color: var(--m-cyan); text-decoration: none; font-size: 0.85rem; display:inline-flex; align-items:center; gap:0.3rem;"><svg class="header-icon" style="width:14px; height:14px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Admin Panel</a></p>
</footer>

</body>
</html>
