<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\SettingsService;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Listar posts publicados con paginación.
     */
    public function index(): View
    {
        $posts = Post::published()
            ->with('categories')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('public.blog.index', compact('posts'));
    }

    /**
     * Mostrar un post publicado por su slug.
     */
    public function show(string $slug): View
    {
        $post = Post::published()
            ->with(['categories', 'tags', 'user'])
            ->where('slug', $slug)
            ->first();

        if ($post === null) {
            abort(404);
        }

        $sanitizedBody = \App\Services\HtmlSanitizerService::sanitize($post->body ?? '');

        return view('public.blog.show', compact('post', 'sanitizedBody'));
    }

    /**
     * Generar feed RSS con los últimos 20 posts publicados.
     */
    public function feed(): Response
    {
        $posts = Post::published()
            ->with('categories')
            ->orderByDesc('published_at')
            ->take(20)
            ->get();

        $siteName = SettingsService::get('site_name', 'WebComposer');
        $siteDescription = SettingsService::get('site_description', '');

        return response()
            ->view('public.blog.feed', compact('posts', 'siteName', 'siteDescription'))
            ->header('Content-Type', 'application/xml');
    }
}
