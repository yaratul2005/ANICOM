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

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; line-height: 1.6; margin: 0; padding: 0; color: #333; background: #fafafa; }
        header { background: #111; color: #fff; padding: 1rem 2rem; }
        header h1 { margin: 0; font-size: 1.5rem; }
        main { padding: 2rem; max-width: 1200px; margin: 0 auto; background: #fff; min-height: 60vh; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-top: 2rem; }
        footer { text-align: center; padding: 2rem; color: #666; margin-top: 2rem; border-top: 1px solid #ddd; }
    </style>
</head>
<body>
    <header style="background: white; border-bottom: 1px solid #e2e8f0; padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">ANICOM</div>
        <nav style="display: flex; gap: 2rem;">
            <a href="/" style="color: #475569; text-decoration: none; font-weight: 500;">Home</a>
            <a href="/cart" style="color: #475569; text-decoration: none; font-weight: 500;">
                Cart (<?= array_sum(array_column(\Core\Cart::getItems(), 'quantity')) ?>)
            </a>
            <a href="/admin/" style="color: var(--primary); text-decoration: none; font-weight: 600;">Admin</a>
        </nav>
    </header>
    
    <main>
        <?= $content ?? '' ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> ANICOM. The minimal, serverless-capable ecommerce framework.</p>
    </footer>
</body>
</html>
