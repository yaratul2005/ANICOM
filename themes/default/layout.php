<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Storefront', ENT_QUOTES, 'UTF-8') ?></title>

    <?= \Core\SEO::generateMetaTags(
        $title ?? 'Storefront',
        'Fast and reliable ecommerce powered by ANICOM',
        isset($product['image']) ? '/uploads/products/' . $product['image'] : ''
    ) ?>

    <?= \Core\SEO::generateSchema(isset($product) ? 'Product' : 'Store', ['product' => $product ?? null]) ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --accent: #c084fc;
            --bg: #fafafa;
            --text: #1e293b;
            --muted: #64748b;
            --border: #e2e8f0;
            --white: #ffffff;
            --card-shadow: 0 4px 6px -1px rgba(0,0,0,0.04), 0 2px 4px -1px rgba(0,0,0,0.03);
            --hover-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        /* ========= HEADER ========= */
        .site-header {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            transition: box-shadow 0.3s;
        }
        .site-header.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

        .header-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 0 2rem;
            display: flex; align-items: center; justify-content: space-between;
            height: 72px;
        }

        .logo {
            font-size: 1.6rem; font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: -1px; text-decoration: none;
        }

        .header-nav { display: flex; align-items: center; gap: 2rem; }
        .header-nav a {
            color: var(--muted); text-decoration: none; font-weight: 500;
            font-size: 0.95rem; transition: color 0.2s; position: relative;
        }
        .header-nav a::after {
            content: ''; position: absolute; bottom: -3px; left: 0; right: 0;
            height: 2px; background: var(--primary); border-radius: 2px;
            transform: scaleX(0); transition: transform 0.2s;
        }
        .header-nav a:hover { color: var(--primary); }
        .header-nav a:hover::after { transform: scaleX(1); }

        .cart-link {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 1.25rem; background: var(--primary);
            color: #fff !important; border-radius: 25px; font-weight: 600;
            text-decoration: none; transition: all 0.2s; font-size: 0.9rem;
        }
        .cart-link:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.35); }
        .cart-link::after { display: none !important; }
        .cart-badge {
            display: inline-flex; align-items: center; justify-content: center;
            width: 20px; height: 20px; background: #fff; color: var(--primary);
            border-radius: 50%; font-size: 0.72rem; font-weight: 800;
        }

        .account-btn {
            display: flex; align-items: center; gap: 0.4rem;
            padding: 0.45rem 1rem; border: 1.5px solid var(--border);
            border-radius: 25px; color: var(--text) !important;
            text-decoration: none; font-weight: 600; font-size: 0.85rem;
            transition: all 0.2s;
        }
        .account-btn:hover { border-color: var(--primary); color: var(--primary) !important; }
        .account-btn::after { display: none !important; }

        /* ========= MAIN ========= */
        .page-wrap {
            max-width: 1280px; margin: 0 auto;
            padding: 3rem 2rem;
        }

        /* ========= FOOTER ========= */
        .site-footer {
            border-top: 1px solid var(--border);
            padding: 3rem 2rem;
            text-align: center;
            color: var(--muted);
            font-size: 0.88rem;
            margin-top: 4rem;
        }
        .site-footer strong { color: var(--primary); }

        /* ========= SCROLL TRIGGER ========= */
    </style>

    <script>
        window.addEventListener('scroll', () => {
            document.querySelector('.site-header')?.classList.toggle('scrolled', window.scrollY > 10);
        });
    </script>
</head>
<body>

<header class="site-header" id="site-header">
    <div class="header-inner">
        <a href="/" class="logo">ANICOM</a>

        <nav class="header-nav">
            <a href="/">Shop</a>
            <?php
            $cartCount = array_sum(array_column(\Core\Cart::getItems(), 'quantity'));
            $customer  = \Core\Customer::current();
            if ($customer): ?>
                <a href="/account" class="account-btn">👤 <?= htmlspecialchars(explode(' ', $customer['name'])[0]) ?></a>
            <?php else: ?>
                <a href="/account/login" class="account-btn">Sign In</a>
            <?php endif; ?>
            <a href="/cart" class="cart-link">
                🛒 Cart
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
    <p>&copy; <?= date('Y') ?> <strong>ANICOM</strong>. The minimal, serverless-capable ecommerce framework.</p>
    <p style="margin-top: 0.5rem;"><a href="/admin/" style="color: var(--muted); text-decoration: none; font-size: 0.8rem;">Admin Panel</a></p>
</footer>

</body>
</html>
