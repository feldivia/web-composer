<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\PageVersion;

/**
 * Servicio para cargar y guardar la estructura de páginas del editor GrapesJS.
 *
 * El campo `content` de la página almacena un JSON con las claves:
 * html, components, styles. El campo `css` almacena los estilos generados.
 *
 * SEGURIDAD: El HTML y CSS se sanitizan al guardar para prevenir XSS almacenado.
 */
class PageBuilderService
{
    /**
     * Carga la estructura de una página para el editor GrapesJS.
     *
     * @param  Page  $page  Página a cargar
     * @return array{html: string, css: string, components: array, styles: array}
     *
     * Ejemplo de respuesta:
     * ```json
     * {
     *   "html": "<section class='hero'>...</section>",
     *   "css": ".hero { padding: 2rem; }",
     *   "components": [],
     *   "styles": []
     * }
     * ```
     */
    public function load(Page $page): array
    {
        $content = $page->content ?? [];

        return [
            'html' => $content['html'] ?? '',
            'css' => $page->css ?? '',
            'components' => $content['components'] ?? [],
            'styles' => $content['styles'] ?? [],
        ];
    }

    /**
     * Guarda la estructura del editor GrapesJS en la página.
     *
     * @param  Page   $page  Página destino
     * @param  array  $data  Datos del editor con claves: html, css, components, styles
     * @return bool   true si se guardó correctamente
     *
     * Ejemplo de request:
     * ```json
     * {
     *   "html": "<section class='hero'>...</section>",
     *   "css": ".hero { padding: 2rem; }",
     *   "components": [{"type": "text", "content": "Hola"}],
     *   "styles": [{"selectors": [".hero"], "style": {"padding": "2rem"}}]
     * }
     * ```
     */
    public function store(Page $page, array $data): bool
    {
        $html = $data['html'] ?? '';
        $css = $data['css'] ?? '';

        // Sanitizar HTML y CSS al guardar para prevenir XSS almacenado
        $page->content = [
            'html' => HtmlSanitizerService::sanitize($html),
            'components' => $data['components'] ?? [],
            'styles' => $data['styles'] ?? [],
            // Preservar datos del section editor si existen
            'sections' => $data['sections'] ?? ($page->content['sections'] ?? []),
            'section_content' => $data['section_content'] ?? ($page->content['section_content'] ?? []),
            'colors' => $data['colors'] ?? ($page->content['colors'] ?? []),
            'fonts' => $data['fonts'] ?? ($page->content['fonts'] ?? []),
            'business_name' => $data['business_name'] ?? ($page->content['business_name'] ?? ''),
            'business_description' => $data['business_description'] ?? ($page->content['business_description'] ?? ''),
        ];

        $page->css = HtmlSanitizerService::sanitizeCss($css);

        $saved = $page->save();

        if ($saved) {
            self::createVersion($page);
        }

        return $saved;
    }

    /**
     * Crea una versión de la página actual. Máximo 6 versiones, elimina la más antigua.
     */
    public static function createVersion(Page $page, ?string $label = null): void
    {
        $count = PageVersion::where('page_id', $page->id)->count();

        // Si ya hay 6 versiones, eliminar la más antigua
        if ($count >= 6) {
            PageVersion::where('page_id', $page->id)
                ->orderBy('created_at')
                ->limit($count - 5)
                ->delete();
        }

        PageVersion::create([
            'page_id' => $page->id,
            'content' => $page->content,
            'css' => $page->css,
            'label' => $label,
            'created_at' => now(),
        ]);
    }

    /**
     * Restaura una versión específica de la página.
     */
    public static function restoreVersion(Page $page, int $versionId): bool
    {
        $version = PageVersion::where('page_id', $page->id)
            ->where('id', $versionId)
            ->first();

        if (!$version) {
            return false;
        }

        // Guardar versión actual antes de restaurar
        self::createVersion($page, 'Antes de restaurar');

        $page->content = $version->content;
        $page->css = $version->css;

        return $page->save();
    }
}
