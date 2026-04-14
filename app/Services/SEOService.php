<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Servicio de generación de meta tags, schema.org y datos SEO.
 */
class SEOService
{
    /**
     * Genera schema Organization + WebSite para el layout base.
     * Se inyecta en todas las páginas del sitio.
     */
    public static function generateGlobalSchemas(): string
    {
        $siteName = SettingsService::get('site_name') ?? 'WebComposer';
        $siteDesc = SettingsService::get('site_description') ?? '';
        $siteLogo = SettingsService::get('site_logo');
        $siteUrl = url('/');

        // Recopilar redes sociales
        $sameAs = array_values(array_filter([
            SettingsService::get('social_facebook'),
            SettingsService::get('social_instagram'),
            SettingsService::get('social_twitter'),
            SettingsService::get('social_linkedin'),
            SettingsService::get('social_youtube'),
        ]));

        // Schema Organization
        $org = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => $siteUrl,
            'description' => $siteDesc,
        ];

        if ($siteLogo) {
            $org['logo'] = [
                '@type' => 'ImageObject',
                'url' => url($siteLogo),
            ];
        }

        $phone = SettingsService::get('whatsapp_number');
        if ($phone) {
            $org['telephone'] = $phone;
        }

        $email = SettingsService::get('mail_from_address') ?: SettingsService::get('mail_to');
        if ($email) {
            $org['email'] = $email;
        }

        if (!empty($sameAs)) {
            $org['sameAs'] = $sameAs;
        }

        // Schema WebSite
        $website = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => $siteUrl,
            'description' => $siteDesc,
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteName,
            ],
        ];

        $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

        return '<script type="application/ld+json">' . json_encode($org, $flags) . '</script>' . "\n"
            . '    <script type="application/ld+json">' . json_encode($website, $flags) . '</script>';
    }

    /**
     * Genera schema WebPage para una página del CMS.
     */
    public static function generatePageSchema(array $data): string
    {
        $siteName = SettingsService::get('site_name') ?? 'WebComposer';

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $data['title'] ?? $siteName,
            'description' => Str::limit($data['description'] ?? '', 160),
            'url' => $data['url'] ?? url()->current(),
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteName,
            ],
        ];

        if (!empty($data['og_image'])) {
            $schema['primaryImageOfPage'] = [
                '@type' => 'ImageObject',
                'url' => url($data['og_image']),
            ];
        }

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }

    /**
     * Genera schema BlogPosting para un post.
     */
    public static function generatePostSchema(array $data): string
    {
        $siteName = SettingsService::get('site_name') ?? 'WebComposer';
        $siteLogo = SettingsService::get('site_logo');

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $data['title'] ?? '',
            'description' => Str::limit($data['description'] ?? '', 160),
            'url' => $data['url'] ?? url()->current(),
            'datePublished' => $data['published_at'] ?? null,
            'dateModified' => $data['updated_at'] ?? $data['published_at'] ?? null,
            'author' => [
                '@type' => 'Person',
                'name' => $data['author'] ?? 'Admin',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteName,
            ],
        ];

        if ($siteLogo) {
            $schema['publisher']['logo'] = [
                '@type' => 'ImageObject',
                'url' => url($siteLogo),
            ];
        }

        if (!empty($data['og_image'])) {
            $schema['image'] = url($data['og_image']);
        }

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }

    /**
     * Genera schema BreadcrumbList automático.
     */
    public static function generateBreadcrumbs(array $items): string
    {
        $list = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        foreach ($items as $i => $item) {
            $list['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        return '<script type="application/ld+json">' . json_encode($list, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }

    /**
     * Genera los meta tags HTML para una entidad.
     */
    public static function generateMetaTags(array $data): string
    {
        $siteName = SettingsService::get('site_name') ?? 'WebComposer';
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

        $tags[] = '<meta name="twitter:card" content="summary_large_image">';
        $tags[] = '<meta name="twitter:title" content="' . e($title) . '">';
        $tags[] = '<meta name="twitter:description" content="' . e($description) . '">';
        if ($image) {
            $tags[] = '<meta name="twitter:image" content="' . e(url($image)) . '">';
        }

        return implode("\n    ", $tags);
    }
}
