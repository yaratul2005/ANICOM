<?php
namespace Core;

class SEO
{
    /**
     * Generates a dynamic JSON-LD Schema based on the exact page loaded.
     */
    public static function generateSchema($pageType = 'Store', $data = [])
    {
        $schema = [
            '@context' => 'https://schema.org',
        ];

        $storeName = Config::get('app.name', 'ANICOM Store');

        if ($pageType === 'Product' && !empty($data['product'])) {
            $p = $data['product'];
            $schema['@type'] = 'Product';
            $schema['name'] = $p['title'];
            if (!empty($p['image'])) {
                $schema['image'] = [Config::get('app.url') . '/uploads/products/' . $p['image']];
            }
            $schema['offers'] = [
                '@type' => 'Offer',
                'priceCurrency' => 'USD',
                'price' => $p['price'],
                'availability' => 'https://schema.org/InStock',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => $storeName
                ]
            ];
        } else {
            // Default WebSite Schema
            $schema['@type'] = 'WebSite';
            $schema['name'] = $storeName;
            $schema['url'] = Config::get('app.url');
        }

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }

    /**
     * Standard Open Graph Meta Tags
     */
    public static function generateMetaTags($title, $description = '', $image = '')
    {
        $tags = [
            '<meta property="og:title" content="' . htmlspecialchars($title, ENT_QUOTES) . '">',
            '<meta property="og:type" content="website">',
            '<meta property="og:url" content="' . htmlspecialchars(Config::get('app.url') . $_SERVER['REQUEST_URI'], ENT_QUOTES) . '">'
        ];

        if ($description) {
            $tags[] = '<meta property="og:description" content="' . htmlspecialchars($description, ENT_QUOTES) . '">';
            $tags[] = '<meta name="description" content="' . htmlspecialchars($description, ENT_QUOTES) . '">';
        }

        if ($image) {
            $tags[] = '<meta property="og:image" content="' . htmlspecialchars(Config::get('app.url') . $image, ENT_QUOTES) . '">';
        }

        return implode("\n    ", $tags);
    }
}
