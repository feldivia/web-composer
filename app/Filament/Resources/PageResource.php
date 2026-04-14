<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?int $navigationSort = 1;

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
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('seo_description')
                            ->maxLength(500),

                        Forms\Components\FileUpload::make('og_image')
                            ->image()
                            ->directory('pages'),
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
                //
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
