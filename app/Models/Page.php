<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasSEO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, HasSEO, SoftDeletes;

    /**
     * Los valores permitidos para el campo type.
     */
    public const TYPE_PAGE = 'page';
    public const TYPE_LANDING = 'landing';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'type',
        'content',
        'css',
        'is_homepage',
        'status',
        'published_at',
        'sort_order',
        'seo_title',
        'seo_description',
        'og_image',
        'template',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_homepage' => 'boolean',
            'published_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope: solo páginas publicadas.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope: solo la página marcada como homepage.
     */
    public function scopeHomepage(Builder $query): Builder
    {
        return $query->where('is_homepage', true);
    }

    /**
     * Relación: submissions de formulario recibidas en esta página.
     */
    public function formSubmissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }

    /**
     * Relación: versiones guardadas de esta página (máximo 6).
     */
    public function versions(): HasMany
    {
        return $this->hasMany(PageVersion::class)->orderByDesc('created_at');
    }
}
