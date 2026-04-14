<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Comando para publicar automáticamente posts y páginas programados
 * cuya fecha de publicación ya pasó.
 *
 * Diseñado para ejecutarse cada minuto via cron:
 * * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
 */
class PublishScheduledPosts extends Command
{
    /**
     * @var string
     */
    protected $signature = 'posts:publish-scheduled';

    /**
     * @var string
     */
    protected $description = 'Publica posts y páginas programados cuya fecha de publicación ya pasó';

    /**
     * Ejecuta el comando.
     */
    public function handle(): int
    {
        $publishedPosts = $this->publishScheduledPosts();
        $publishedPages = $this->publishScheduledPages();

        $totalPublished = $publishedPosts + $publishedPages;

        if ($totalPublished > 0) {
            $message = "Publicación automática: {$publishedPosts} post(s) y {$publishedPages} página(s) publicados.";
            $this->info($message);
            Log::info($message);
        } else {
            $this->info('No hay contenido programado pendiente de publicar.');
        }

        return self::SUCCESS;
    }

    /**
     * Publica posts programados cuya fecha ya pasó.
     */
    private function publishScheduledPosts(): int
    {
        $posts = Post::where('status', 'scheduled')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get();

        foreach ($posts as $post) {
            $post->update(['status' => 'published']);
            Log::info("Post publicado automáticamente: [{$post->id}] {$post->title}");
        }

        return $posts->count();
    }

    /**
     * Publica páginas programadas cuya fecha ya pasó.
     */
    private function publishScheduledPages(): int
    {
        $pages = Page::where('status', 'scheduled')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get();

        foreach ($pages as $page) {
            $page->update(['status' => 'published']);
            Log::info("Página publicada automáticamente: [{$page->id}] {$page->title}");
        }

        return $pages->count();
    }
}
