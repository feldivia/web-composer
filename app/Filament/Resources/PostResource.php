<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?int $navigationSort = 2;

    /**
     * Filtra la consulta para que los Writers solo vean sus propios posts.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var User|null $user */
        $user = auth()->user();

        if ($user !== null && $user->isWriter()) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => auth()->id())
                    ->dehydrated(true),

                Forms\Components\Section::make('Post Details')
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

                        Forms\Components\RichEditor::make('body')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('excerpt')
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('posts'),

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

                        Forms\Components\DateTimePicker::make('published_at')
                            ->hint("Si el estado es 'Programado', el post se publicará automáticamente en esta fecha")
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
                    ])->columns(2),

                Forms\Components\Section::make('Taxonomy')
                    ->schema([
                        Forms\Components\Select::make('categories')
                            ->multiple()
                            ->relationship('categories', 'name')
                            ->preload(),

                        Forms\Components\Select::make('tags')
                            ->multiple()
                            ->relationship('tags', 'name')
                            ->preload(),
                    ])->columns(2),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('seo_description')
                            ->maxLength(500),

                        Forms\Components\FileUpload::make('og_image')
                            ->image()
                            ->directory('posts'),
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

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'scheduled' => 'warning',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('categories.name')
                    ->badge(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Post $record): string => url('/blog/' . $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicar')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (Post $record): void {
                        $timestamp = now()->timestamp;

                        /** @var Post $duplicate */
                        $duplicate = Post::create([
                            'user_id' => (int) auth()->id(),
                            'title' => "Copia de {$record->title}",
                            'slug' => "{$record->slug}-copia-{$timestamp}",
                            'body' => $record->body,
                            'excerpt' => $record->excerpt,
                            'featured_image' => $record->featured_image,
                            'status' => 'draft',
                            'published_at' => null,
                            'seo_title' => $record->seo_title,
                            'seo_description' => $record->seo_description,
                            'og_image' => $record->og_image,
                        ]);

                        // Copiar relaciones de categorías y tags
                        $duplicate->categories()->sync($record->categories->pluck('id'));
                        $duplicate->tags()->sync($record->tags->pluck('id'));

                        Notification::make()
                            ->title('Post duplicado correctamente')
                            ->success()
                            ->send();

                        redirect(PostResource::getUrl('edit', ['record' => $duplicate]));
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
