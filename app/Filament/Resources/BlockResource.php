<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BlockResource\Pages;
use App\Models\Block;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class BlockResource extends Resource
{
    protected static ?string $model = Block::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Diseño';

    protected static ?string $navigationLabel = 'Bloques';

    protected static ?string $modelLabel = 'Bloque';

    protected static ?string $pluralModelLabel = 'Bloques';

    protected static ?int $navigationSort = 1;

    /**
     * Solo Admin y Editor pueden acceder a bloques.
     */
    public static function canAccess(): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user !== null && $user->hasRole([User::ROLE_ADMIN, User::ROLE_EDITOR]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Bloque')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('category')
                            ->label('Categoría')
                            ->options(Block::CATEGORIES)
                            ->required()
                            ->searchable(),

                        Forms\Components\Textarea::make('description')
                            ->label('Descripción')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Contenido HTML')
                    ->schema([
                        Forms\Components\Textarea::make('content.html')
                            ->label('HTML')
                            ->rows(16)
                            ->columnSpanFull()
                            ->extraAttributes(['style' => 'font-family: monospace; font-size: 0.85rem;']),

                        Forms\Components\Textarea::make('content.css')
                            ->label('CSS')
                            ->rows(12)
                            ->columnSpanFull()
                            ->extraAttributes(['style' => 'font-family: monospace; font-size: 0.85rem;']),
                    ]),

                Forms\Components\Section::make('Imagen de Referencia')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('blocks')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450'),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Categoría')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'heroes' => 'primary',
                        'contenido' => 'info',
                        'features' => 'success',
                        'testimonios' => 'warning',
                        'precios' => 'danger',
                        'contacto' => 'gray',
                        'galeria' => 'info',
                        'footer' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => Block::CATEGORIES[$state] ?? $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('category')
            ->defaultGroup('category')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoría')
                    ->options(Block::CATEGORIES),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Vista Previa')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (Block $record): string => "Vista Previa: {$record->name}")
                    ->modalWidth('5xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar')
                    ->modalCloseButton(true)
                    ->modalContent(function (Block $record): HtmlString {
                        $html = $record->content['html'] ?? '';
                        $css = $record->content['css'] ?? '';

                        $iframeSrc = "data:text/html;charset=utf-8," . rawurlencode(
                            '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">'
                            . '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">'
                            . '<style>*{margin:0;padding:0;box-sizing:border-box}body{font-family:"Inter",sans-serif;}'
                            . ':root{--color-primary:#6366f1;--color-secondary:#0ea5e9;--color-accent:#f59e0b;--color-text:#1e293b;--color-background:#ffffff;--font-heading:"Inter",sans-serif;--font-body:"Inter",sans-serif;}'
                            . $css . '</style></head><body>' . $html . '</body></html>'
                        );

                        return new HtmlString(
                            '<iframe src="' . $iframeSrc . '" style="width:100%;min-height:400px;max-height:70vh;border:1px solid #e2e8f0;border-radius:8px;" sandbox="allow-same-origin"></iframe>'
                        );
                    }),

                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicar')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalHeading('Duplicar Bloque')
                    ->modalDescription('Se creará una copia de este bloque con el nombre modificado.')
                    ->action(function (Block $record): void {
                        $newBlock = $record->replicate();
                        $newBlock->name = $record->name . ' (copia)';
                        $newBlock->save();
                    }),

                Tables\Actions\EditAction::make()
                    ->label('Editar'),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar seleccionados'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlocks::route('/'),
            'create' => Pages\CreateBlock::route('/create'),
            'edit' => Pages\EditBlock::route('/{record}/edit'),
        ];
    }
}
