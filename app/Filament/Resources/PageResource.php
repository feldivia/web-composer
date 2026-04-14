<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use App\Models\PageVersion;
use App\Models\User;
use App\Services\PageBuilderService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Diseño';

    protected static ?string $navigationLabel = 'Páginas';

    protected static ?int $navigationSort = 0;

    /**
     * Solo Admin y Editor pueden acceder al recurso de páginas.
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
                Forms\Components\Section::make('Page Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, Set $set): void {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state ?? ''));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('type')
                            ->options([
                                'page' => 'Page',
                                'landing' => 'Landing',
                            ])
                            ->default('page')
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'scheduled' => 'Scheduled',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required()
                            ->live(),

                        Forms\Components\Toggle::make('is_homepage')
                            ->default(false),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->hint("Si el estado es 'Programado', la página se publicará automáticamente en esta fecha")
                            ->required(fn (Forms\Get $get): bool => $get('status') === 'scheduled')
                            ->rules([
                                fn (Forms\Get $get): \Closure => function (string $attribute, mixed $value, \Closure $fail) use ($get): void {
                                    if ($get('status') === 'scheduled') {
                                        if (empty($value)) {
                                            $fail('La fecha de publicación es obligatoria cuando el estado es Programado.');
                                            return;
                                        }
                                        $date = $value instanceof \DateTimeInterface ? $value : new \DateTime($value);
                                        if ($date <= now()) {
                                            $fail('La fecha de publicación debe ser futura cuando el estado es Programado.');
                                        }
                                    }
                                },
                            ]),

                        Forms\Components\TextInput::make('template')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('SEO')
                    ->description('Optimiza cómo se ve tu página en Google y redes sociales. Los schemas se generan automáticamente.')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('Título SEO')
                            ->helperText('60-70 caracteres ideal. Si vacío, usa el título de la página.')
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Set $set) => null),

                        Forms\Components\Textarea::make('seo_description')
                            ->label('Descripción SEO')
                            ->helperText('150-160 caracteres ideal. Aparece debajo del título en Google.')
                            ->maxLength(500)
                            ->rows(3)
                            ->live(onBlur: true),

                        Forms\Components\FileUpload::make('og_image')
                            ->label('Imagen para redes sociales')
                            ->helperText('Recomendado: 1200x630px. Se muestra al compartir en Facebook, Twitter, etc.')
                            ->image()
                            ->directory('pages'),

                        Forms\Components\Placeholder::make('seo_preview')
                            ->label('Vista previa en Google')
                            ->content(function ($record, $get): HtmlString {
                                $title = $get('seo_title') ?: ($record?->title ?? 'Título de la página');
                                $desc = $get('seo_description') ?: 'Descripción de la página que aparecerá en los resultados de búsqueda...';
                                $slug = $record?->slug ?? 'pagina';
                                $domain = parse_url(config('app.url'), PHP_URL_HOST) ?: 'tusitio.com';

                                $titleLen = mb_strlen($title);
                                $descLen = mb_strlen($desc);
                                $titleColor = $titleLen > 70 ? '#ef4444' : ($titleLen > 60 ? '#f59e0b' : '#10b981');
                                $descColor = $descLen > 160 ? '#ef4444' : ($descLen > 150 ? '#f59e0b' : '#10b981');

                                return new HtmlString('
                                    <div style="max-width:600px;font-family:Arial,sans-serif;margin-top:4px;">
                                        <div style="font-size:11px;color:#4d5156;margin-bottom:2px;">' . e($domain) . ' › ' . e($slug) . '</div>
                                        <div style="font-size:18px;color:#1a0dab;font-weight:400;margin-bottom:3px;line-height:1.3;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' . e(\Illuminate\Support\Str::limit($title, 70)) . '</div>
                                        <div style="font-size:13px;color:#4d5156;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">' . e(\Illuminate\Support\Str::limit($desc, 160)) . '</div>
                                        <div style="margin-top:8px;font-size:11px;">
                                            <span style="color:' . $titleColor . ';">Título: ' . $titleLen . '/70</span>
                                            &nbsp;·&nbsp;
                                            <span style="color:' . $descColor . ';">Descripción: ' . $descLen . '/160</span>
                                        </div>
                                    </div>
                                ');
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug'),

                Tables\Columns\TextColumn::make('type')
                    ->badge(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'scheduled' => 'warning',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_homepage')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('builder')
                    ->label(function (Page $record): string {
                        $content = $record->content;
                        $hasContent = is_array($content)
                            && !empty($content['html'])
                            && trim($content['html']) !== '';

                        return $hasContent ? 'Diseñar' : 'Crear con IA';
                    })
                    ->icon(function (Page $record): string {
                        $content = $record->content;
                        $hasContent = is_array($content)
                            && !empty($content['html'])
                            && trim($content['html']) !== '';

                        return $hasContent ? 'heroicon-o-pencil-square' : 'heroicon-o-sparkles';
                    })
                    ->color(function (Page $record): string {
                        $content = $record->content;
                        $hasContent = is_array($content)
                            && !empty($content['html'])
                            && trim($content['html']) !== '';

                        return $hasContent ? 'info' : 'warning';
                    })
                    ->url(function (Page $record): string {
                        $content = $record->content;
                        $hasContent = is_array($content)
                            && !empty($content['html'])
                            && trim($content['html']) !== '';

                        if (! $hasContent) {
                            return route('builder.wizard', $record);
                        }

                        return route('builder.sections', $record);
                    }),
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (Page $record): string => route('page.preview', $record), shouldOpenInNewTab: true),
                Tables\Actions\EditAction::make()
                    ->label('Configurar'),
                Tables\Actions\Action::make('versions')
                    ->label('Versiones')
                    ->icon('heroicon-o-clock')
                    ->color('gray')
                    ->modalHeading('Historial de versiones')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar')
                    ->modalContent(function (Page $record): \Illuminate\Contracts\View\View {
                        $versions = $record->versions()->limit(6)->get();

                        return view('filament.pages.page-versions', [
                            'versions' => $versions,
                            'page' => $record,
                        ]);
                    })
                    ->visible(fn (Page $record): bool => $record->versions()->exists()),
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicar')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (Page $record): void {
                        $timestamp = now()->timestamp;

                        /** @var Page $duplicate */
                        $duplicate = Page::create([
                            'title' => "Copia de {$record->title}",
                            'slug' => "{$record->slug}-copia-{$timestamp}",
                            'type' => $record->type,
                            'content' => $record->content,
                            'css' => $record->css,
                            'is_homepage' => false,
                            'status' => 'draft',
                            'published_at' => null,
                            'sort_order' => $record->sort_order,
                            'seo_title' => $record->seo_title,
                            'seo_description' => $record->seo_description,
                            'og_image' => $record->og_image,
                            'template' => $record->template,
                        ]);

                        Notification::make()
                            ->title('Página duplicada correctamente')
                            ->success()
                            ->send();

                        redirect(PageResource::getUrl('edit', ['record' => $duplicate]));
                    }),
                Tables\Actions\Action::make('export')
                    ->label('Exportar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(function (Page $record) {
                        $data = [
                            'title' => $record->title,
                            'slug' => $record->slug,
                            'type' => $record->type,
                            'content' => $record->content,
                            'css' => $record->css,
                            'seo_title' => $record->seo_title,
                            'seo_description' => $record->seo_description,
                            'template' => $record->template,
                            'exported_at' => now()->toISOString(),
                        ];

                        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        $filename = 'backup-' . $record->slug . '-' . now()->format('Y-m-d-His') . '.json';

                        return response()->streamDownload(function () use ($json) {
                            echo $json;
                        }, $filename, ['Content-Type' => 'application/json']);
                    }),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                \Illuminate\Database\Eloquent\SoftDeletingScope::class,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
