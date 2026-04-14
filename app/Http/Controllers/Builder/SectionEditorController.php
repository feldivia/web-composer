<?php

declare(strict_types=1);

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\AIService;
use App\Services\SectionLibraryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            'library' => SectionLibraryService::allMetadata(),
        ]);
    }

    /**
     * Agrega una sola seccion a la pagina (sin regenerar las existentes).
     *
     * Genera contenido IA solo para la nueva seccion, la renderiza
     * y retorna el HTML fragment para inyectar en el DOM sin reload.
     *
     * POST /builder/{page}/sections/add
     *
     * @param  Request  $request
     * @param  Page     $page
     * @return JsonResponse
     */
    public function addSection(Request $request, Page $page): JsonResponse
    {
        $validated = $request->validate([
            'section_id' => 'required|string',
            'insert_index' => 'required|integer|min:-1',
        ]);

        $sectionId = $validated['section_id'];
        $insertIndex = (int) $validated['insert_index'];

        // Verificar que la seccion existe
        $sectionMeta = SectionLibraryService::get($sectionId);
        if ($sectionMeta === null) {
            return response()->json(['success' => false, 'message' => 'Seccion no encontrada'], 404);
        }

        try {
            $content = $page->content ?? [];
            $sectionIds = $content['sections'] ?? [];
            $sectionContent = $content['section_content'] ?? [];
            $colors = $content['colors'] ?? [
                'primary' => '#6366F1', 'secondary' => '#0EA5E9',
                'accent' => '#F59E0B', 'background' => '#FFFFFF', 'text' => '#1E293B',
            ];
            $fonts = $content['fonts'] ?? ['heading' => 'Space Grotesk', 'body' => 'Inter'];
            $businessName = $content['business_name'] ?? $page->title;
            $businessDescription = $content['business_description'] ?? '';

            // Generar contenido IA solo para la nueva seccion
            $newContent = [];
            if (!empty($businessName) && !empty($businessDescription)) {
                try {
                    $aiService = new AIService();
                    $generated = $aiService->generateSectionContent(
                        businessName: $businessName,
                        businessDescription: $businessDescription,
                        sections: [$sectionId],
                    );
                    $newContent = $generated[$sectionId] ?? [];
                } catch (\Exception $e) {
                    Log::warning('AI generation failed for single section, using defaults', [
                        'section_id' => $sectionId,
                        'error' => $e->getMessage(),
                    ]);
                    // Usar contenido default si la IA falla
                }
            }

            // Renderizar la nueva seccion
            $renderedHtml = SectionLibraryService::render($sectionId, $newContent, $colors, $fonts);

            // Insertar en las listas
            if ($insertIndex === -1 || $insertIndex >= count($sectionIds)) {
                $sectionIds[] = $sectionId;
            } else {
                array_splice($sectionIds, $insertIndex, 0, [$sectionId]);
            }
            $sectionContent[$sectionId] = $newContent;

            // CSS combinado actualizado
            $combinedCss = SectionLibraryService::getCss($sectionIds);

            // Guardar en BD
            $content['sections'] = $sectionIds;
            $content['section_content'] = $sectionContent;
            $content['css'] = $combinedCss;

            // Reconstruir HTML completo
            $htmlParts = [];
            foreach ($sectionIds as $sid) {
                $sc = $sectionContent[$sid] ?? [];
                $r = SectionLibraryService::render($sid, $sc, $colors, $fonts);
                if ($r) {
                    $htmlParts[] = $r;
                }
            }
            $content['html'] = implode("\n", $htmlParts);

            $page->update([
                'content' => $content,
                'css' => $combinedCss,
            ]);

            return response()->json([
                'success' => true,
                'html' => $renderedHtml,
                'css' => $combinedCss,
                'section_content' => $newContent,
                'section_ids' => $sectionIds,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to add section', [
                'page_id' => $page->id,
                'section_id' => $sectionId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al agregar seccion. Intenta de nuevo.',
            ], 500);
        }
    }

    /**
     * Re-renderiza una seccion con contenido actualizado.
     *
     * POST /builder/{page}/sections/render
     *
     * @param  Request  $request
     * @param  Page     $page
     * @return JsonResponse
     */
    public function renderSection(Request $request, Page $page): JsonResponse
    {
        $validated = $request->validate([
            'section_id' => 'required|string',
            'content' => 'required|array',
        ]);

        $sectionId = $validated['section_id'];
        $sectionMeta = SectionLibraryService::get($sectionId);

        if ($sectionMeta === null) {
            return response()->json(['success' => false, 'message' => 'Seccion no encontrada'], 404);
        }

        $pageContent = $page->content ?? [];
        $colors = $pageContent['colors'] ?? [
            'primary' => '#6366F1', 'secondary' => '#0EA5E9',
            'accent' => '#F59E0B', 'background' => '#FFFFFF', 'text' => '#1E293B',
        ];
        $fonts = $pageContent['fonts'] ?? ['heading' => 'Space Grotesk', 'body' => 'Inter'];

        $html = SectionLibraryService::render($sectionId, $validated['content'], $colors, $fonts);

        // Actualizar section_content en la pagina
        $sectionContent = $pageContent['section_content'] ?? [];
        $sectionContent[$sectionId] = $validated['content'];
        $pageContent['section_content'] = $sectionContent;
        $page->update(['content' => $pageContent]);

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    /**
     * Retorna los placeholders y contenido actual de una seccion.
     *
     * GET /builder/{page}/sections/{sectionId}/edit
     *
     * @param  Page    $page
     * @param  string  $sectionId
     * @return JsonResponse
     */
    public function editSection(Page $page, string $sectionId): JsonResponse
    {
        $sectionMeta = SectionLibraryService::get($sectionId);

        if ($sectionMeta === null) {
            return response()->json(['success' => false, 'message' => 'Seccion no encontrada'], 404);
        }

        $pageContent = $page->content ?? [];
        $currentContent = $pageContent['section_content'][$sectionId] ?? [];

        // Merge defaults with current content
        $fields = [];
        foreach ($sectionMeta['placeholders'] as $key => $placeholder) {
            $fields[] = [
                'key' => $key,
                'type' => $placeholder['type'],
                'label' => $placeholder['label'],
                'value' => $currentContent[$key] ?? $placeholder['default'],
            ];
        }

        return response()->json([
            'success' => true,
            'section_id' => $sectionId,
            'section_name' => $sectionMeta['name'],
            'section_icon' => $sectionMeta['icon'],
            'fields' => $fields,
        ]);
    }
}
