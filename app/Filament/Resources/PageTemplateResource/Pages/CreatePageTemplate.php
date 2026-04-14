<?php

declare(strict_types=1);

namespace App\Filament\Resources\PageTemplateResource\Pages;

use App\Filament\Resources\PageTemplateResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePageTemplate extends CreateRecord
{
    protected static string $resource = PageTemplateResource::class;
}
