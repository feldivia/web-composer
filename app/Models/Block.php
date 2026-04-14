<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    /**
     * Categorias predefinidas para bloques.
     */
    public const CATEGORIES = [
        'heroes' => 'Heroes',
        'contenido' => 'Contenido',
        'features' => 'Features',
        'testimonios' => 'Testimonios',
        'precios' => 'Precios',
        'contacto' => 'Contacto',
        'galeria' => 'Galeria',
        'social' => 'Social Proof',
        'sitio' => 'Sitio Web',
        'footer' => 'Footer',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'content',
        'thumbnail',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }
}
