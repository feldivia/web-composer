<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SectionLibraryService;
use Illuminate\Http\JsonResponse;

/**
 * Controlador API para la librería de secciones premium.
 *
 * Provee metadatos de las secciones disponibles (sin HTML/CSS completo)
 * para que el editor GrapesJS pueda mostrar el catálogo al usuario.
 */
class SectionLibraryController extends Controller
{
    /**
     * Lista todas las secciones disponibles con sus metadatos.
     *
     * Retorna id, nombre, categoría, descripción, icono y placeholders.
     * No incluye HTML/CSS completo para mantener la respuesta liviana.
     *
     * GET /api/sections
     *
     * @return JsonResponse
     *
     * Ejemplo de respuesta:
     * {
     *   "data": [
     *     {
     *       "id": "hero-split",
     *       "name": "Hero con Imagen",
     *       "category": "heroes",
     *       "description": "Titulo grande + subtitulo + CTAs a la izquierda, imagen a la derecha",
     *       "icon": "🎯",
     *       "placeholders": { ... }
     *     },
     *     ...
     *   ],
     *   "categories": {
     *     "heroes": 4,
     *     "services": 4,
     *     ...
     *   }
     * }
     */
    public function index(): JsonResponse
    {
        $metadata = SectionLibraryService::metadata();
        $grouped = SectionLibraryService::all();

        $categoryCounts = [];
        foreach ($grouped as $category => $data) {
            $categoryCounts[$category] = count($data['sections'] ?? []);
        }

        return response()->json([
            'data' => $metadata,
            'categories' => $categoryCounts,
        ]);
    }

    /**
     * Retorna una sección completa por su ID (incluyendo HTML y CSS).
     *
     * GET /api/sections/{id}
     *
     * @param string $id Identificador de la sección
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $section = SectionLibraryService::get($id);

        if ($section === null) {
            return response()->json([
                'error' => 'Sección no encontrada',
            ], 404);
        }

        return response()->json([
            'data' => $section,
        ]);
    }

    /**
     * Retorna un preview HTML renderizado de una sección con contenido default.
     *
     * GET /api/sections/{id}/preview
     *
     * @param string $id Identificador de la sección
     * @return \Illuminate\Http\Response|JsonResponse
     */
    public function preview(string $id)
    {
        $section = SectionLibraryService::get($id);

        if ($section === null) {
            return response()->json(['error' => 'Sección no encontrada'], 404);
        }

        // Colores y fuentes por defecto para el preview
        $defaultColors = [
            'primary' => '#6366F1',
            'secondary' => '#0EA5E9',
            'accent' => '#F59E0B',
            'background' => '#FFFFFF',
            'text' => '#1E293B',
        ];
        $defaultFonts = [
            'heading' => 'Space Grotesk',
            'body' => 'Inter',
        ];

        // Renderizar con contenido default (placeholders vacíos = usa defaults)
        $html = SectionLibraryService::render($id, [], $defaultColors, $defaultFonts);
        $css = $section['css'] ?? '';

        // Secciones con fondo transparente necesitan un fondo oscuro para contraste
        $needsDarkBg = in_array($section['category'], ['navbar'], true)
            && str_contains($id, 'transparent');
        $bodyBg = $needsDarkBg ? 'background:#0F172A;min-height:400px;' : 'background:#fff;';

        return response(
            '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">'
            . '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
            . '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">'
            . '<style>*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}body{font-family:Inter,sans-serif;' . $bodyBg . '}'
            . $css . '</style></head><body>' . $html . '</body></html>',
            200,
            ['Content-Type' => 'text/html']
        );
    }
}
