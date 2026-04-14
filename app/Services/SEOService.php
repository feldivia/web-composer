<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Servicio de generación de meta tags y datos SEO.
 *
 * Genera meta tags HTML, schema.org markup, y sitemap XML
 * para páginas y posts del CMS.
 */
class SEOService
{
    /**
     * Genera los meta tags HTML para una entidad.
     *
     * @param  array{title?: string, description?: string, og_image?: string, url?: string, type?: string}  $data
     * @return string  HTML de meta tags
     */
    public static function generateMetaTags(array $data): string
    {
        $siteName = SettingsService::get('site_name', 'WebComposer');
        $title = $data['title'] ?? $siteName;
        $description = Str::limit($data['description'] ?? '', 160);
        $image = $data['og_image'] ?? null;
        $url = $data['url'] ?? url()->current();
        $type = $data['type'] ?? 'website';

        $tags = [];
        $tags[] = '<meta property="og:title" content="' . e($title) . '">';
        $tags[] = '<meta property="og:description" content="' . e($description) . '">';
        $tags[] = '<meta property="og:url" content="' . e($url) . '">';
        $tags[] = '<meta property="og:type" content="' . e($type) . '">';
        $tags[] = '<meta property="og:site_name" content="' . e($siteName) . '">';

        if ($image) {
            $tags[] = '<meta property="og:image" content="' . e(url($image)) . '">';
        }

        // Twitter Card
        $tags[] = '<meta name="twitter:card" content="summary_large_image">';
        $tags[] = '<meta name="twitter:title" content="' . e($title) . '">';
        $tags[] = '<meta name="twitter:description" content="' . e($description) . '">';
        if ($image) {
            $tags[] = '<meta name="twitter:image" content="' . e(url($image)) . '">';
        }

        return implode("\n    ", $tags);
    }

    /**
     * Genera schema.org JSON-LD para una página o post.
     *
     * @param  string  $type  'WebPage' o 'BlogPosting'
     * @param  array   $data
     * @return string  Script tag con JSON-LD
     */
    public static function generateSchemaMarkup(string $type, array $data): string
    {
        $siteName = SettingsService::get('site_name', 'WebComposer');

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $type,
            'name' => $data['title'] ?? $siteName,
            'description' => $data['description'] ?? '',
            'url' => $data['url'] ?? url()->current(),
        ];

        if ($type === 'BlogPosting') {
            $schema['datePublished'] = $data['published_at'] ?? null;
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $data['author'] ?? 'Admin',
            ];
            if (isset($data['og_image'])) {
                $schema['image'] = url($data['og_image']);
            }
        }

        $schema['publisher'] = [
            '@type' => 'Organization',
            'name' => $siteName,
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
