<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Servicio de librería de secciones premium pre-construidas.
 *
 * Provee secciones HTML/CSS pixel-perfect organizadas por categoría.
 * La IA solo rellena contenido textual — nunca diseña CSS.
 *
 * Uso:
 *   SectionLibraryService::all()                        → Todas las secciones agrupadas por categoría
 *   SectionLibraryService::byCategory('heroes')         → Secciones de una categoría
 *   SectionLibraryService::get('hero-split')            → Una sección por ID
 *   SectionLibraryService::render('hero-split', [...])  → HTML renderizado con contenido
 *   SectionLibraryService::getCss(['hero-split', ...])  → CSS combinado de varias secciones
 */
class SectionLibraryService
{
    /**
     * Caché en memoria del registro de secciones.
     *
     * @var array<string, array>|null
     */
    private static ?array $cachedRegistry = null;

    /**
     * Retorna todas las secciones disponibles agrupadas por categoría.
     *
     * @return array<string, array<int, array>> Mapa categoría → secciones
     */
    public static function all(): array
    {
        $sections = self::registry();
        $grouped = [];

        $categoryNames = self::categoryNames();

        foreach ($sections as $section) {
            $cat = $section['category'];
            if (!isset($grouped[$cat])) {
                $grouped[$cat] = [
                    'name' => $categoryNames[$cat] ?? ucfirst($cat),
                    'sections' => [],
                ];
            }
            $grouped[$cat]['sections'][] = $section;
        }

        // Reorder: navbar first, then rest
        $ordered = [];
        if (isset($grouped['navbar'])) {
            $ordered['navbar'] = $grouped['navbar'];
            unset($grouped['navbar']);
        }
        $ordered = array_merge($ordered, $grouped);

        return $ordered;
    }

    /**
     * Retorna las secciones de una categoría específica.
     *
     * @param string $category Slug de la categoría (heroes, services, about, etc.)
     * @return array<int, array> Lista de secciones en esa categoría
     */
    public static function byCategory(string $category): array
    {
        $sections = self::registry();

        return array_values(array_filter($sections, function (array $section) use ($category) {
            return $section['category'] === $category;
        }));
    }

    /**
     * Retorna una sección por su ID.
     *
     * @param string $id Identificador único de la sección (ej: 'hero-split')
     * @return array|null Definición completa de la sección o null si no existe
     */
    public static function get(string $id): ?array
    {
        $sections = self::registry();

        return $sections[$id] ?? null;
    }

    /**
     * Renderiza una sección reemplazando placeholders con contenido real.
     *
     * Proceso:
     * 1. Obtiene el template HTML de la sección
     * 2. Reemplaza {{placeholder}} con valores de $content
     * 3. Reemplaza {{color_*}} con colores reales
     * 4. Reemplaza {{font_*}} con fuentes reales
     * 5. Renderiza arrays (stats, features, etc.) como HTML
     *
     * @param string $id ID de la sección
     * @param array<string, mixed> $content Valores para los placeholders
     * @param array<string, string> $colors Colores del sitio (primary, secondary, accent, background, text)
     * @param array<string, string> $fonts Fuentes del sitio (heading, body)
     * @return string HTML renderizado listo para insertar
     */
    public static function render(string $id, array $content, array $colors, array $fonts): string
    {
        $section = self::get($id);

        if ($section === null) {
            return '';
        }

        $html = $section['html'];

        // Auto-inyectar logo del sitio para navbars si no se provee
        if ($section['category'] === 'navbar' && empty($content['brand_logo'])) {
            $siteLogo = SettingsService::get('site_logo');
            if ($siteLogo) {
                $content['brand_logo'] = $siteLogo;
            }
        }

        // Reemplazar placeholders de contenido
        foreach ($section['placeholders'] as $key => $placeholder) {
            $value = $content[$key] ?? $placeholder['default'];

            if ($placeholder['type'] === 'image' && $key === 'brand_logo') {
                $value = self::renderBrandLogo($value, $id, $content['brand_name'] ?? '');
            } elseif ($placeholder['type'] === 'stats') {
                $value = self::renderStats($value, $id);
            } elseif ($placeholder['type'] === 'features') {
                $value = self::renderFeatures($value, $id);
            } elseif ($placeholder['type'] === 'list') {
                $value = self::renderList($value, $id);
            } elseif ($placeholder['type'] === 'links') {
                $value = self::renderLinks($value, $id);
            } elseif ($placeholder['type'] === 'testimonials') {
                $value = self::renderTestimonials($value, $id);
            } elseif ($placeholder['type'] === 'pricing') {
                $value = self::renderPricing($value, $id);
            } elseif ($placeholder['type'] === 'faq') {
                $value = self::renderFaq($value, $id);
            } elseif ($placeholder['type'] === 'gallery') {
                $value = self::renderGallery($value, $id);
            } elseif ($placeholder['type'] === 'marquee') {
                $value = self::renderMarquee($value, $id);
            } elseif (is_array($value)) {
                $value = implode(', ', $value);
            }

            $html = str_replace('{{' . $key . '}}', (string) $value, $html);
        }

        // Reemplazar variables de color
        foreach ($colors as $key => $color) {
            $html = str_replace('{{color_' . $key . '}}', $color, $html);
        }

        // Reemplazar variables de fuente
        foreach ($fonts as $key => $font) {
            $html = str_replace('{{font_' . $key . '}}', $font, $html);
        }

        return $html;
    }

    /**
     * Retorna todas las secciones agrupadas por categoría, sin HTML/CSS (solo metadatos).
     *
     * Ideal para pasar al frontend (wizard, editor) donde solo se necesitan
     * id, name, description, icon para construir el catálogo visual.
     *
     * @return array<string, array{name: string, sections: array}>
     */
    public static function allMetadata(): array
    {
        $sections = self::registry();
        $grouped = [];

        $categoryNames = self::categoryNames();

        foreach ($sections as $section) {
            $cat = $section['category'];
            if (!isset($grouped[$cat])) {
                $grouped[$cat] = [
                    'name' => $categoryNames[$cat] ?? ucfirst($cat),
                    'sections' => [],
                ];
            }
            $grouped[$cat]['sections'][] = [
                'id' => $section['id'],
                'name' => $section['name'],
                'category' => $section['category'],
                'description' => $section['description'],
                'icon' => $section['icon'],
            ];
        }

        // Reorder: navbar first
        $ordered = [];
        if (isset($grouped['navbar'])) {
            $ordered['navbar'] = $grouped['navbar'];
            unset($grouped['navbar']);
        }
        $ordered = array_merge($ordered, $grouped);

        return $ordered;
    }

    /**
     * Retorna el CSS combinado para un conjunto de secciones.
     *
     * Cada sección tiene CSS con clases prefijadas (.wc-{id}-) para evitar conflictos.
     *
     * @param array<int, string> $sectionIds Lista de IDs de secciones
     * @return string CSS combinado
     */
    public static function getCss(array $sectionIds): string
    {
        $css = '';

        foreach ($sectionIds as $id) {
            $section = self::get($id);
            if ($section !== null) {
                $css .= "\n/* === Section: {$section['name']} ({$id}) === */\n";
                $css .= $section['css'] . "\n";
            }
        }

        return $css;
    }

    /**
     * Retorna metadatos de todas las secciones (sin HTML/CSS completo).
     *
     * Útil para la API de listado donde no se necesita el contenido pesado.
     *
     * @return array<int, array{id: string, name: string, category: string, description: string, icon: string, placeholders: array}>
     */
    public static function metadata(): array
    {
        $sections = self::registry();
        $meta = [];

        foreach ($sections as $section) {
            $meta[] = [
                'id' => $section['id'],
                'name' => $section['name'],
                'category' => $section['category'],
                'description' => $section['description'],
                'icon' => $section['icon'],
                'placeholders' => $section['placeholders'],
            ];
        }

        return $meta;
    }

    /**
     * Retorna el registro completo de secciones.
     *
     * Carga las definiciones de cada archivo en app/Services/SectionLibrary/
     * y las cachea en memoria durante la ejecución del request.
     *
     * @return array<string, array> Mapa id → definición completa
     */
    private static function registry(): array
    {
        if (self::$cachedRegistry !== null) {
            return self::$cachedRegistry;
        }

        $sections = [];
        $files = glob(__DIR__ . '/SectionLibrary/*.php');

        foreach ($files as $file) {
            $definition = require $file;
            if (is_array($definition) && isset($definition['id'])) {
                $sections[$definition['id']] = $definition;
            }
        }

        self::$cachedRegistry = $sections;

        return $sections;
    }

    /**
     * Mapa centralizado de nombres de categorías.
     *
     * @return array<string, string>
     */
    private static function categoryNames(): array
    {
        return [
            'navbar' => 'Navegación',
            'heroes' => 'Heroes',
            'services' => 'Servicios',
            'about' => 'Acerca de',
            'trust' => 'Confianza / Stats',
            'testimonials' => 'Testimonios',
            'pricing' => 'Precios',
            'faq' => 'Preguntas Frecuentes',
            'contact' => 'Contacto',
            'cta' => 'Llamada a la Acción',
            'gallery' => 'Galería',
            'quote' => 'Citas',
            'footer' => 'Footer',
            'marquee' => 'Marquee',
        ];
    }

    /**
     * Renderiza un array de estadísticas como HTML.
     *
     * @param array<int, array{number: string, label: string}> $stats
     * @param string $sectionId ID de la sección para prefijo CSS
     * @return string HTML renderizado
     */
    private static function renderStats(array $stats, string $sectionId): string
    {
        $html = '';
        foreach ($stats as $stat) {
            $number = htmlspecialchars($stat['number'] ?? '', ENT_QUOTES, 'UTF-8');
            $label = htmlspecialchars($stat['label'] ?? '', ENT_QUOTES, 'UTF-8');
            $html .= "<div class=\"wc-{$sectionId}-stat-item\"><span class=\"wc-{$sectionId}-stat-number\">{$number}</span><span class=\"wc-{$sectionId}-stat-label\">{$label}</span></div>";
        }

        return $html;
    }

    /**
     * Renderiza un array de features/servicios como HTML de cards.
     *
     * @param array<int, array{icon: string, title: string, description: string}> $features
     * @param string $sectionId
     * @return string
     */
    private static function renderFeatures(array $features, string $sectionId): string
    {
        $html = '';
        foreach ($features as $feature) {
            $icon = htmlspecialchars($feature['icon'] ?? '', ENT_QUOTES, 'UTF-8');
            $title = htmlspecialchars($feature['title'] ?? '', ENT_QUOTES, 'UTF-8');
            $desc = htmlspecialchars($feature['description'] ?? '', ENT_QUOTES, 'UTF-8');
            $link = htmlspecialchars($feature['link_text'] ?? 'Consultar', ENT_QUOTES, 'UTF-8');
            $html .= "<div class=\"wc-{$sectionId}-card\"><div class=\"wc-{$sectionId}-card-icon\">{$icon}</div><h3 class=\"wc-{$sectionId}-card-title\">{$title}</h3><p class=\"wc-{$sectionId}-card-desc\">{$desc}</p><a href=\"#\" class=\"wc-{$sectionId}-card-link\">{$link} <span>&rarr;</span></a></div>";
        }

        return $html;
    }

    /**
     * Renderiza una lista de items como HTML.
     *
     * @param array<int, string> $items
     * @param string $sectionId
     * @return string
     */
    private static function renderList(array $items, string $sectionId): string
    {
        $html = '';
        foreach ($items as $item) {
            $text = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
            $html .= "<li class=\"wc-{$sectionId}-list-item\"><span class=\"wc-{$sectionId}-check\">&#10003;</span> {$text}</li>";
        }

        return $html;
    }

    /**
     * Renderiza un array de links como HTML.
     *
     * @param array<int, array{text: string, url: string}> $links
     * @param string $sectionId
     * @return string
     */
    private static function renderLinks(array $links, string $sectionId): string
    {
        $html = '';
        foreach ($links as $link) {
            $text = htmlspecialchars($link['text'] ?? '', ENT_QUOTES, 'UTF-8');
            $url = htmlspecialchars($link['url'] ?? '#', ENT_QUOTES, 'UTF-8');
            $html .= "<li><a href=\"{$url}\" class=\"wc-{$sectionId}-link\">{$text}</a></li>";
        }

        return $html;
    }

    /**
     * Renderiza testimonios como HTML de cards.
     *
     * @param array<int, array{quote: string, name: string, role: string, avatar: string, stars: int}> $testimonials
     * @param string $sectionId
     * @return string
     */
    private static function renderTestimonials(array $testimonials, string $sectionId): string
    {
        $html = '';
        foreach ($testimonials as $t) {
            $quote = htmlspecialchars($t['quote'] ?? '', ENT_QUOTES, 'UTF-8');
            $name = htmlspecialchars($t['name'] ?? '', ENT_QUOTES, 'UTF-8');
            $role = htmlspecialchars($t['role'] ?? '', ENT_QUOTES, 'UTF-8');
            $avatar = htmlspecialchars($t['avatar'] ?? 'https://picsum.photos/seed/avatar/80/80', ENT_QUOTES, 'UTF-8');
            $stars = (int) ($t['stars'] ?? 5);
            $starsHtml = str_repeat('<span class="wc-' . $sectionId . '-star">&#9733;</span>', $stars);
            $html .= "<div class=\"wc-{$sectionId}-card\"><div class=\"wc-{$sectionId}-stars\">{$starsHtml}</div><blockquote class=\"wc-{$sectionId}-quote\">{$quote}</blockquote><div class=\"wc-{$sectionId}-author\"><img src=\"{$avatar}\" alt=\"{$name}\" class=\"wc-{$sectionId}-avatar\"><div><span class=\"wc-{$sectionId}-name\">{$name}</span><span class=\"wc-{$sectionId}-role\">{$role}</span></div></div></div>";
        }

        return $html;
    }

    /**
     * Renderiza planes de pricing como HTML de cards.
     *
     * @param array<int, array{name: string, price: string, period: string, features: array, cta: string, popular: bool}> $plans
     * @param string $sectionId
     * @return string
     */
    private static function renderPricing(array $plans, string $sectionId): string
    {
        $html = '';
        foreach ($plans as $plan) {
            $name = htmlspecialchars($plan['name'] ?? '', ENT_QUOTES, 'UTF-8');
            $price = htmlspecialchars($plan['price'] ?? '', ENT_QUOTES, 'UTF-8');
            $period = htmlspecialchars($plan['period'] ?? '/mes', ENT_QUOTES, 'UTF-8');
            $cta = htmlspecialchars($plan['cta'] ?? 'Elegir plan', ENT_QUOTES, 'UTF-8');
            $popular = !empty($plan['popular']);
            $popularClass = $popular ? " wc-{$sectionId}-card--popular" : '';
            $popularBadge = $popular ? "<span class=\"wc-{$sectionId}-badge\">Popular</span>" : '';
            $featuresHtml = '';
            foreach (($plan['features'] ?? []) as $f) {
                $included = $f['included'] ?? true;
                $fText = htmlspecialchars($f['text'] ?? '', ENT_QUOTES, 'UTF-8');
                $iconClass = $included ? 'wc-' . $sectionId . '-check' : 'wc-' . $sectionId . '-cross';
                $icon = $included ? '&#10003;' : '&#10007;';
                $featuresHtml .= "<li class=\"wc-{$sectionId}-feature\"><span class=\"{$iconClass}\">{$icon}</span> {$fText}</li>";
            }
            $btnClass = $popular ? "wc-{$sectionId}-btn-primary" : "wc-{$sectionId}-btn-ghost";
            $html .= "<div class=\"wc-{$sectionId}-card{$popularClass}\">{$popularBadge}<h3 class=\"wc-{$sectionId}-plan-name\">{$name}</h3><div class=\"wc-{$sectionId}-price\"><span class=\"wc-{$sectionId}-price-amount\">{$price}</span><span class=\"wc-{$sectionId}-price-period\">{$period}</span></div><ul class=\"wc-{$sectionId}-features\">{$featuresHtml}</ul><a href=\"#\" class=\"{$btnClass}\">{$cta}</a></div>";
        }

        return $html;
    }

    /**
     * Renderiza items de FAQ como HTML de acordeón.
     *
     * @param array<int, array{question: string, answer: string}> $items
     * @param string $sectionId
     * @return string
     */
    private static function renderFaq(array $items, string $sectionId): string
    {
        $html = '';
        foreach ($items as $i => $item) {
            $question = htmlspecialchars($item['question'] ?? '', ENT_QUOTES, 'UTF-8');
            $answer = htmlspecialchars($item['answer'] ?? '', ENT_QUOTES, 'UTF-8');
            $open = $i === 0 ? ' wc-' . $sectionId . '-item--open' : '';
            $html .= "<div class=\"wc-{$sectionId}-item{$open}\"><button class=\"wc-{$sectionId}-question\" onclick=\"this.parentElement.classList.toggle('wc-{$sectionId}-item--open')\"><span>{$question}</span><span class=\"wc-{$sectionId}-arrow\"></span></button><div class=\"wc-{$sectionId}-answer\"><p>{$answer}</p></div></div>";
        }

        return $html;
    }

    /**
     * Renderiza items de galería como HTML.
     *
     * @param array<int, array{image: string, title: string, category: string}> $items
     * @param string $sectionId
     * @return string
     */
    private static function renderGallery(array $items, string $sectionId): string
    {
        $html = '';
        foreach ($items as $item) {
            $image = htmlspecialchars($item['image'] ?? 'https://picsum.photos/seed/gallery/600/600', ENT_QUOTES, 'UTF-8');
            $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
            $category = htmlspecialchars($item['category'] ?? '', ENT_QUOTES, 'UTF-8');
            $html .= "<div class=\"wc-{$sectionId}-item\"><img src=\"{$image}\" alt=\"{$title}\" class=\"wc-{$sectionId}-img\" loading=\"lazy\"><div class=\"wc-{$sectionId}-overlay\"><span class=\"wc-{$sectionId}-item-cat\">{$category}</span><span class=\"wc-{$sectionId}-item-title\">{$title}</span></div></div>";
        }

        return $html;
    }

    /**
     * Renderiza items de marquee como HTML.
     *
     * @param array<int, string> $items
     * @param string $sectionId
     * @return string
     */
    private static function renderMarquee(array $items, string $sectionId): string
    {
        $html = '';
        foreach ($items as $item) {
            $text = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
            $html .= "<span class=\"wc-{$sectionId}-text\">{$text}</span><span class=\"wc-{$sectionId}-dot\">&#9679;</span>";
        }

        return $html;
    }

    /**
     * Renderiza el logo de marca: <img> si hay URL, SVG fallback si no.
     *
     * @param string $logoUrl URL del logo (puede estar vacío)
     * @param string $sectionId ID de la sección para prefijo CSS
     * @param string $brandName Nombre de marca para alt text
     * @return string HTML del logo
     */
    private static function renderBrandLogo(string $logoUrl, string $sectionId, string $brandName): string
    {
        $alt = htmlspecialchars($brandName ?: 'Logo', ENT_QUOTES, 'UTF-8');

        if (!empty($logoUrl)) {
            $src = htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8');

            return "<img src=\"{$src}\" alt=\"{$alt}\" class=\"wc-{$sectionId}-brand-logo\">";
        }

        // SVG fallback genérico
        $isTransparent = str_contains($sectionId, 'transparent');
        $fill = $isTransparent
            ? 'rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="1'
            : 'var(--color-primary, #6366F1)';

        return '<span class="wc-' . $sectionId . '-brand-icon">'
            . '<svg width="28" height="28" viewBox="0 0 28 28" fill="none">'
            . '<rect width="28" height="28" rx="8" fill="' . $fill . '"/>'
            . '<path d="M8 14l4 4 8-8" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>'
            . '</svg></span>';
    }
}
