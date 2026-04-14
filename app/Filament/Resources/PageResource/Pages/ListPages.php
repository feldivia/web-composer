<?php

declare(strict_types=1);

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\Page;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('import')
                ->label('Importar backup')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->form([
                    Forms\Components\FileUpload::make('backup_file')
                        ->label('Archivo de backup (.json)')
                        ->acceptedFileTypes(['application/json'])
                        ->required()
                        ->disk('local')
                        ->directory('temp-imports'),
                ])
                ->action(function (array $data): void {
                    $path = storage_path('app/' . $data['backup_file']);

                    if (!file_exists($path)) {
                        Notification::make()->title('Archivo no encontrado')->danger()->send();
                        return;
                    }

                    $json = file_get_contents($path);
                    $backup = json_decode($json, true);

                    if (!$backup || empty($backup['title'])) {
                        Notification::make()->title('Archivo de backup inválido')->danger()->send();
                        @unlink($path);
                        return;
                    }

                    $slug = $backup['slug'] . '-imported-' . now()->timestamp;

                    Page::create([
                        'title' => $backup['title'] . ' (importada)',
                        'slug' => $slug,
                        'type' => $backup['type'] ?? 'page',
                        'content' => $backup['content'] ?? [],
                        'css' => $backup['css'] ?? '',
                        'status' => 'draft',
                        'seo_title' => $backup['seo_title'] ?? null,
                        'seo_description' => $backup['seo_description'] ?? null,
                        'template' => $backup['template'] ?? null,
                    ]);

                    @unlink($path);

                    Notification::make()
                        ->title('Página importada correctamente')
                        ->body('La página se creó como borrador.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
