<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PageTemplate;
use App\Services\HtmlSanitizerService;
use Illuminate\Http\Response;

class TemplatePreviewController extends Controller
{
    /**
     * Preview de un template por su slug — solo usuarios autenticados.
     */
    public function show(string $slug): Response
    {
        $template = PageTemplate::where('slug', $slug)->first();

        if ($template === null) {
            abort(404);
        }

        $content = $template->content;
        $sanitizedHtml = HtmlSanitizerService::sanitize($content['html'] ?? '');
        $sanitizedCss = HtmlSanitizerService::sanitizeCss($content['css'] ?? '');

        return response()
            ->view('public.template-preview', [
                'template' => $template,
                'sanitizedHtml' => $sanitizedHtml,
                'sanitizedCss' => $sanitizedCss,
            ]);
    }

    /**
     * Listado de templates con thumbnails para preview.
     */
    public function index(): Response
    {
        $templates = PageTemplate::orderBy('name')->get();

        return response()
            ->view('public.template-gallery', [
                'templates' => $templates,
            ]);
    }
}
