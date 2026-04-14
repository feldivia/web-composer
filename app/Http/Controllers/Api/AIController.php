<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controller para los endpoints de IA.
 *
 * Todos los endpoints requieren autenticación y están limitados por rate limiting.
 */
class AIController extends Controller
{
    public function __construct(
        private readonly AIService $aiService,
    ) {}

    /**
     * Genera texto para una sección específica.
     *
     * POST /api/ai/generate-text
     * Body: { section_type, business_type, tone?, language? }
     *
     * Response: { title, subtitle, description, cta }
     */
    public function generateText(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'section_type' => ['required', 'string', 'max:50'],
            'business_type' => ['required', 'string', 'max:100'],
            'tone' => ['sometimes', 'string', 'max:50'],
            'language' => ['sometimes', 'string', 'max:5'],
        ]);

        try {
            $result = $this->aiService->generateText(
                sectionType: $validated['section_type'],
                businessType: $validated['business_type'],
                tone: $validated['tone'] ?? 'profesional',
                language: $validated['language'] ?? 'es',
            );

            return response()->json($result);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 429);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar texto.'], 500);
        }
    }

    /**
     * Genera sugerencias SEO.
     *
     * POST /api/ai/generate-seo
     * Body: { title, content, language? }
     *
     * Response: { seo_title, seo_description, keywords[], og_title }
     */
    public function generateSEO(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'language' => ['sometimes', 'string', 'max:5'],
        ]);

        try {
            $result = $this->aiService->generateSEO(
                title: $validated['title'],
                content: $validated['content'],
                language: $validated['language'] ?? 'es',
            );

            return response()->json($result);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 429);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar SEO.'], 500);
        }
    }

    /**
     * Traduce contenido.
     *
     * POST /api/ai/translate
     * Body: { content, target_language, source_language? }
     *
     * Response: { translated, source_language }
     */
    public function translate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string'],
            'target_language' => ['required', 'string', 'max:5'],
            'source_language' => ['sometimes', 'string', 'max:5'],
        ]);

        try {
            $result = $this->aiService->translate(
                content: $validated['content'],
                targetLanguage: $validated['target_language'],
                sourceLanguage: $validated['source_language'] ?? '',
            );

            return response()->json($result);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 429);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al traducir.'], 500);
        }
    }

    /**
     * Genera una estructura de página completa.
     *
     * POST /api/ai/generate-page
     * Body: { business_type, description, sections?, language? }
     *
     * Response: { html, css }
     */
    public function generatePage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'business_type' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'sections' => ['sometimes', 'string', 'max:500'],
            'language' => ['sometimes', 'string', 'max:5'],
        ]);

        try {
            $result = $this->aiService->generatePage(
                businessType: $validated['business_type'],
                description: $validated['description'],
                sections: $validated['sections'] ?? '',
                language: $validated['language'] ?? 'es',
            );

            return response()->json($result);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 429);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar página.'], 500);
        }
    }

    /**
     * Regenera una sección existente con instrucciones del usuario.
     *
     * POST /api/ai/regenerate-section
     * Body: { section_type, current_html, instructions?, tone?, colors? }
     *
     * Response: { html: '<section ...>new content</section>' }
     */
    public function regenerateSection(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'section_type' => ['required', 'string', 'max:50'],
            'current_html' => ['required', 'string', 'max:50000'],
            'instructions' => ['sometimes', 'string', 'max:1000'],
            'tone' => ['sometimes', 'string', 'max:50'],
            'colors' => ['sometimes', 'array'],
            'colors.primary' => ['sometimes', 'string', 'max:20'],
            'colors.secondary' => ['sometimes', 'string', 'max:20'],
            'colors.accent' => ['sometimes', 'string', 'max:20'],
            'colors.background' => ['sometimes', 'string', 'max:20'],
            'colors.text' => ['sometimes', 'string', 'max:20'],
        ]);

        try {
            $html = $this->aiService->regenerateSection(
                sectionType: $validated['section_type'],
                currentHtml: $validated['current_html'],
                instructions: $validated['instructions'] ?? '',
                tone: $validated['tone'] ?? 'profesional',
                colors: $validated['colors'] ?? [],
            );

            return response()->json(['html' => $html]);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 429);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al regenerar sección.'], 500);
        }
    }

    /**
     * Genera una nueva sección individual.
     *
     * POST /api/ai/generate-section
     * Body: { section_type, business_context?, description?, colors? }
     *
     * Response: { html: '<section ...>new content</section>' }
     */
    public function generateSection(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'section_type' => ['required', 'string', 'max:50'],
            'business_context' => ['sometimes', 'string', 'max:1000'],
            'description' => ['sometimes', 'string', 'max:1000'],
            'colors' => ['sometimes', 'array'],
            'colors.primary' => ['sometimes', 'string', 'max:20'],
            'colors.secondary' => ['sometimes', 'string', 'max:20'],
            'colors.accent' => ['sometimes', 'string', 'max:20'],
            'colors.background' => ['sometimes', 'string', 'max:20'],
            'colors.text' => ['sometimes', 'string', 'max:20'],
        ]);

        try {
            $html = $this->aiService->generateSection(
                sectionType: $validated['section_type'],
                businessContext: $validated['business_context'] ?? '',
                description: $validated['description'] ?? '',
                colors: $validated['colors'] ?? [],
            );

            return response()->json(['html' => $html]);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 429);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar sección.'], 500);
        }
    }

    /**
     * Genera variantes de copy.
     *
     * POST /api/ai/generate-variants
     * Body: { text, variants?, tone? }
     *
     * Response: { variants[] }
     */
    public function generateVariants(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:2000'],
            'variants' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'tone' => ['sometimes', 'string', 'max:50'],
        ]);

        try {
            $result = $this->aiService->generateVariants(
                originalText: $validated['text'],
                variants: $validated['variants'] ?? 3,
                tone: $validated['tone'] ?? 'profesional',
            );

            return response()->json($result);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 429);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar variantes.'], 500);
        }
    }
}
