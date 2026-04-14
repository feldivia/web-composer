<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PageTemplateResource\Pages;
use App\Models\PageTemplate;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageTemplateResource extends Resource
{
    protected static ?string $model = PageTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationGroup = 'Diseno';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Templates';

    /**
     * Solo Admin puede acceder a templates.
     */
    public static function canAccess(): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user !== null && $user->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Template Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('category')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->directory('templates'),

                        Forms\Components\Toggle::make('is_default')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Fonts')
                    ->schema([
                        Forms\Components\KeyValue::make('fonts')
                            ->keyLabel('Property')
                            ->valueLabel('Font Family'),
                    ]),

                Forms\Components\Section::make('Colors')
                    ->schema([
                        Forms\Components\KeyValue::make('colors')
                            ->keyLabel('Property')
                            ->valueLabel('Color Value'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug'),

                Tables\Columns\TextColumn::make('category'),

                Tables\Columns\IconColumn::make('is_default')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (PageTemplate $record): string => route('templates.preview', $record->slug), shouldOpenInNewTab: true),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPageTemplates::route('/'),
            'create' => Pages\CreatePageTemplate::route('/create'),
            'edit' => Pages\EditPageTemplate::route('/{record}/edit'),
        ];
    }
}
