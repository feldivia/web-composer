<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\HtmlSanitizerService;
use Illuminate\Http\Response;

class PageController extends Controller
{
    /**
     * Mostrar la página marcada como homepage.
     */
    public function homepage(): Response
    {
        $page = Page::published()->homepage()->first();

        if ($page === null) {
            abort(404);
        }

        return $this->cachedResponse($page);
    }

    /**
     * Mostrar una página publicada por su slug.
     */
    public function show(string $slug): Response
    {
        $page = Page::published()->where('slug', $slug)->first();

        if ($page === null) {
            abort(404);
        }

        return $this->cachedResponse($page);
    }

    /**
     * Preview de cualquier página (draft/scheduled/published) — solo usuarios autenticados.
     */
    public function preview(Page $page): Response
    {
        $sanitizedHtml = HtmlSanitizerService::sanitize($page->content['html'] ?? '');
        $sanitizedCss = HtmlSanitizerService::sanitizeCss($page->css ?? '');

        return response()
            ->view('public.page', [
                'page' => $page,
                'sanitizedHtml' => $sanitizedHtml,
                'sanitizedCss' => $sanitizedCss,
                'isPreview' => true,
            ]);
    }

    /**
     * Respuesta con headers de caché HTTP.
     */
    private function cachedResponse(Page $page): Response
    {
        $etag = md5((string) $page->updated_at);

        // Sanitize page content for safe rendering
        $sanitizedHtml = HtmlSanitizerService::sanitize($page->content['html'] ?? '');
        $sanitizedCss = HtmlSanitizerService::sanitizeCss($page->css ?? '');

        return response()
            ->view('public.page', [
                'page' => $page,
                'sanitizedHtml' => $sanitizedHtml,
                'sanitizedCss' => $sanitizedCss,
            ])
            ->header('Cache-Control', 'public, max-age=300, s-maxage=600')
            ->header('ETag', '"' . $etag . '"')
            ->header('Last-Modified', $page->updated_at->toRfc7231String());
    }
}
