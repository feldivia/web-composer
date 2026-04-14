<?php

declare(strict_types=1);

namespace App\Traits;

trait HasSEO
{
    /**
     * Obtiene el título SEO, usando seo_title si existe o el título del modelo.
     */
    public function getSeoTitle(): string
    {
        return $this->seo_title ?: ($this->title ?? '');
    }

    /**
     * Obtiene la descripción SEO, usando seo_description si existe o un extracto del contenido.
     */
    public function getSeoDescription(): string
    {
        if ($this->seo_description) {
            return $this->seo_description;
        }

        $text = $this->excerpt ?? $this->body ?? '';

        if (empty($text) && isset($this->content)) {
            $text = is_array($this->content)
                ? ($this->content['html'] ?? '')
                : (string) $this->content;
        }

        $text = strip_tags((string) $text);

        return mb_strlen($text) > 160
            ? mb_substr($text, 0, 157) . '...'
            : $text;
    }

    /**
     * Obtiene la imagen Open Graph.
     */
    public function getOgImage(): ?string
    {
        return $this->og_image;
    }
}
