<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TemplateService;
use Illuminate\Http\JsonResponse;

class TemplateController extends Controller
{
    public function __construct(
        private readonly TemplateService $templateService,
    ) {}

    /**
     * Listar todos los templates disponibles.
     */
    public function index(): JsonResponse
    {
        $templates = $this->templateService->list();

        return response()->json($templates);
    }

    /**
     * Cargar la estructura de un template por slug.
     */
    public function show(string $slug): JsonResponse
    {
        $template = $this->templateService->load($slug);

        if ($template === null) {
            abort(404, 'Template no encontrado.');
        }

        return response()->json($template);
    }
}
