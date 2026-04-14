<?php

declare(strict_types=1);

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\SectionLibraryService;
use Illuminate\View\View;

/**
 * Controlador del editor simplificado de secciones.
 *
 * Alternativa al editor GrapesJS. Muestra las secciones renderizadas
 * con edicion inline de texto y controles de reordenamiento/gestion.
 */
class SectionEditorController extends Controller
{
    /**
     * Muestra el editor de secciones para una pagina.
     *
     * Parsea el contenido de la pagina para identificar secciones
     * por su atributo data-section-type y las presenta en un editor
     * visual inline.
     *
     * @param  Page  $page
     * @return View
     */
    public function show(Page $page): View
    {
        $content = $page->content ?? [];
        $sectionIds = $content['sections'] ?? [];
        $sectionContent = $content['section_content'] ?? [];
        $colors = $content['colors'] ?? [
            'primary' => '#6366F1',
            'secondary' => '#0EA5E9',
            'accent' => '#F59E0B',
            'background' => '#FFFFFF',
            'text' => '#1E293B',
        ];
        $fonts = $content['fonts'] ?? [
            'heading' => 'Space Grotesk',
            'body' => 'Inter',
        ];
        $businessName = $content['business_name'] ?? $page->title;
        $businessDescription = $content['business_description'] ?? '';

        // Renderizar cada seccion con su contenido actual
        $renderedSections = [];
        foreach ($sectionIds as $sectionId) {
            $sectionMeta = SectionLibraryService::get($sectionId);
            if ($sectionMeta === null) {
                continue;
            }
            $rendered = SectionLibraryService::render(
                $sectionId,
                $sectionContent[$sectionId] ?? [],
                $colors,
                $fonts
            );
            $renderedSections[] = [
                'id' => $sectionId,
                'name' => $sectionMeta['name'] ?? $sectionId,
                'icon' => $sectionMeta['icon'] ?? '',
                'html' => $rendered,
            ];
        }

        // CSS combinado
        $combinedCss = SectionLibraryService::getCss($sectionIds);

        return view('builder.section-editor', [
            'page' => $page,
            'renderedSections' => $renderedSections,
            'combinedCss' => $combinedCss,
            'sectionIds' => $sectionIds,
            'sectionContent' => $sectionContent,
            'colors' => $colors,
            'fonts' => $fonts,
            'businessName' => $businessName,
            'businessDescription' => $businessDescription,
            'library' => SectionLibraryService::all(),
        ]);
    }
}
