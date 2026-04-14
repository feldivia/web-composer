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
}
