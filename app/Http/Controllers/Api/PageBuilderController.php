<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\PageBuilderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    public function __construct(
        private readonly PageBuilderService $pageBuilderService,
    ) {}

    /**
     * Cargar la estructura de una página para GrapesJS.
     */
    public function load(Page $page): JsonResponse
    {
        $data = $this->pageBuilderService->load($page);

        return response()->json($data);
    }

    /**
     * Guardar la estructura de una página desde GrapesJS.
     */
    public function store(Request $request, Page $page): JsonResponse
    {
        $validated = $request->validate([
            'html' => ['required', 'string'],
            'css' => ['required', 'string'],
            'components' => ['required', 'array'],
            'styles' => ['required', 'array'],
        ]);

        $success = $this->pageBuilderService->store($page, $validated);

        if ($request->has('status') && in_array($request->input('status'), ['draft', 'published', 'archived'], true)) {
            $page->status = $request->input('status');
            if ($request->input('status') === 'published' && !$page->published_at) {
                $page->published_at = now();
            }
            $page->save();
        }

        if ($success) {
            return response()->json(['message' => 'Página guardada correctamente.']);
        }

        return response()->json(['message' => 'Error al guardar la página.'], 500);
    }
}
