<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $pages = Page::published()->orderBy('updated_at', 'desc')->get();
        $posts = Post::published()->orderBy('updated_at', 'desc')->get();

        return response()
            ->view('public.sitemap', compact('pages', 'posts'))
            ->header('Content-Type', 'application/xml');
    }
}
