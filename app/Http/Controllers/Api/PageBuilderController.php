<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\PageBuilderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly PageBuilderService $pageBuilderService,
    ) {}

    /**
     * Cargar la estructura de una página para GrapesJS.
     */
    public function load(Page $page): JsonResponse
    {
        $this->authorize('view', $page);

        $data = $this->pageBuilderService->load($page);

        return response()->json($data);
    }

    /**
     * Guardar la estructura de una página desde GrapesJS.
     */
    public function store(Request $request, Page $page): JsonResponse
    {
        $this->authorize('update', $page);

        $validated = $request->validate([
            'html' => ['required', 'string'],
            'css' => ['nullable', 'string'],
            'components' => ['nullable', 'array'],
            'styles' => ['nullable', 'array'],
            // Section editor fields (optional)
            'sections' => ['nullable', 'array'],
            'section_content' => ['nullable', 'array'],
            'colors' => ['nullable', 'array'],
            'fonts' => ['nullable', 'array'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'business_description' => ['nullable', 'string', 'max:5000'],
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
