<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVersion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'page_id',
        'content',
        'css',
        'label',
        'created_at',
    ];

    protected $casts = [
        'content' => 'array',
        'created_at' => 'datetime',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
