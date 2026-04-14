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
 * Controlador del wizard de IA para generacion de paginas.
 *
 * Flujo: el usuario elige secciones pre-construidas de la biblioteca,
 * la IA genera solo el contenido de texto, y las secciones premium
 * se renderizan con ese contenido.
 */
class AIWizardController extends Controller
{
    /**
     * Muestra el wizard de IA para una pagina.
     *
     * @param  Page  $page  Pagina a la que se le generara contenido
     * @return View
     */
    public function show(Page $page): View
    {
        return view('builder.ai-wizard', [
            'page' => $page,
            'fonts' => config('webcomposer.fonts'),
            'sectionLibrary' => SectionLibraryService::allMetadata(),
        ]);
    }

    /**
     * Procesa el wizard y genera contenido via IA + secciones pre-construidas.
     *
     * 1. Valida input (negocio, secciones, colores, fuentes)
     * 2. Si colores._ai_generate, genera paleta con IA
     * 3. Llama a AIService::generateSectionContent() para obtener textos
     * 4. Renderiza cada seccion con SectionLibraryService::render()
     * 5. Combina HTML y CSS
     * 6. Guarda en la pagina
     * 7. Retorna redirect al editor de secciones
     *
     * @param  Request  $request
     * @param  Page     $page
     * @return JsonResponse
     *
     * Ejemplo request:
     * {
     *   "business_name": "Clinica Dental Sonrisa",
     *   "business_description": "Clinica dental en Santiago...",
     *   "sections": ["hero-split", "services-cards", "testimonials-grid", "contact-split"],
     *   "colors": { "primary": "#6366F1", "secondary": "#0EA5E9", "accent": "#F59E0B", "background": "#FFFFFF", "text": "#1E293B" },
     *   "fonts": { "heading": "Space Grotesk", "body": "Inter" }
     * }
     *
     * Ejemplo response:
     * {
     *   "success": true,
     *   "redirect": "/builder/5/sections",
     *   "message": "Pagina generada exitosamente"
     * }
     */
    public function generate(Request $request, Page $page): JsonResponse
    {
        // Obtener todos los IDs de seccion validos de la biblioteca
        $allSections = SectionLibraryService::all();
        $validSectionIds = [];
        foreach ($allSections as $category) {
            foreach ($category['sections'] ?? [] as $section) {
                $validSectionIds[] = $section['id'];
            }
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_description' => 'required|string|max:5000',
            'sections' => 'required|array|min:2',
            'sections.*' => 'string|in:' . implode(',', $validSectionIds),
            'colors' => 'required|array',
            'fonts' => 'required|array',
            'fonts.heading' => 'required|string|in:' . implode(',', config('webcomposer.fonts', [])),
            'fonts.body' => 'required|string|in:' . implode(',', config('webcomposer.fonts', [])),
        ]);

        try {
            $aiService = new AIService();

            // Si el usuario eligio "IA elige por mi", generar paleta con IA
            $colors = $validated['colors'];
            if (!empty($colors['_ai_generate'])) {
                $colors = $aiService->generateColorPalette(
                    $validated['business_name'],
                    $validated['business_description'],
                );
            }

            $fonts = $validated['fonts'];

            // Generar solo contenido de texto con IA (rapido, 2048-4096 tokens)
            $sectionContent = $aiService->generateSectionContent(
                businessName: $validated['business_name'],
                businessDescription: $validated['business_description'],
                sections: $validated['sections'],
            );

            // Renderizar cada seccion con su contenido
            $htmlParts = [];
            foreach ($validated['sections'] as $sectionId) {
                $content = $sectionContent[$sectionId] ?? [];
                $rendered = SectionLibraryService::render($sectionId, $content, $colors, $fonts);
                if ($rendered) {
                    $htmlParts[] = $rendered;
                }
            }

            $combinedHtml = implode("\n", $htmlParts);

            // Obtener CSS combinado de todas las secciones
            $combinedCss = SectionLibraryService::getCss($validated['sections']);

            // Guardar el contenido en la pagina
            $page->update([
                'content' => [
                    'html' => $combinedHtml,
                    'css' => $combinedCss,
                    'components' => [],
                    'styles' => [],
                    'sections' => $validated['sections'],
                    'section_content' => $sectionContent,
                    'colors' => $colors,
                    'fonts' => $fonts,
                    'business_name' => $validated['business_name'],
                    'business_description' => $validated['business_description'],
                ],
                'css' => $combinedCss,
            ]);

            return response()->json([
                'success' => true,
                'redirect' => route('builder.sections', $page),
                'message' => 'Pagina generada exitosamente',
            ]);
        } catch (\Exception $e) {
            Log::error('AI Wizard generation failed', [
                'page_id' => $page->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al generar la pagina: ' . $e->getMessage(),
            ], 500);
        }
    }
}
