<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PageTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

/**
 * Seeder para cargar los templates precargados desde archivos JSON.
 *
 * Lee cada archivo JSON en database/seeders/templates/ y crea o actualiza
 * el registro correspondiente en la tabla page_templates.
 */
class PageTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templatesPath = database_path('seeders/templates');

        if (! File::isDirectory($templatesPath)) {
            $this->command->warn('Directorio de templates no encontrado: ' . $templatesPath);
            return;
        }

        $files = File::glob($templatesPath . '/*.json');

        if (empty($files)) {
            $this->command->warn('No se encontraron archivos JSON de templates.');
            return;
        }

        foreach ($files as $file) {
            $json = File::get($file);
            $data = json_decode($json, true);

            if ($data === null) {
                $this->command->error('Error al decodificar: ' . basename($file));
                continue;
            }

            PageTemplate::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'category' => $data['category'] ?? null,
                    'description' => $data['description'] ?? null,
                    'thumbnail' => $data['thumbnail'] ?? null,
                    'fonts' => $data['fonts'] ?? null,
                    'colors' => $data['colors'] ?? null,
                    'content' => $data['grapesjs'] ?? null,
                    'is_default' => false,
                ]
            );

            $this->command->info('Template cargado: ' . $data['name']);
        }
    }
}
