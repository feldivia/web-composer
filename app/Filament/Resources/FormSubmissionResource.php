<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\FormSubmissionResource\Pages;
use App\Models\FormSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class FormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Mensajes';

    protected static ?string $modelLabel = 'Mensaje';

    protected static ?string $pluralModelLabel = 'Mensajes';

    /**
     * Muestra badge con cantidad de mensajes no leídos en la navegación.
     */
    public static function getNavigationBadge(): ?string
    {
        $count = FormSubmission::unread()->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        // No se necesita formulario de creación/edición
        return $form->schema([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Datos del contacto')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nombre'),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('phone')
                            ->label('Teléfono')
                            ->copyable()
                            ->placeholder('No proporcionado'),
                        Infolists\Components\TextEntry::make('subject')
                            ->label('Asunto')
                            ->placeholder('Sin asunto'),
                    ])->columns(2),

                Infolists\Components\Section::make('Mensaje')
                    ->schema([
                        Infolists\Components\TextEntry::make('message')
                            ->label('')
                            ->markdown(false)
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Información adicional')
                    ->schema([
                        Infolists\Components\TextEntry::make('page.title')
                            ->label('Página de origen')
                            ->placeholder('No identificada'),
                        Infolists\Components\TextEntry::make('ip_address')
                            ->label('Dirección IP')
                            ->placeholder('No registrada'),
                        Infolists\Components\IconEntry::make('is_read')
                            ->label('Leído')
                            ->boolean(),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Recibido')
                            ->dateTime('d/m/Y H:i'),
                        Infolists\Components\TextEntry::make('data')
                            ->label('Datos extra')
                            ->placeholder('Ninguno')
                            ->visible(fn (FormSubmission $record): bool => !empty($record->data)),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->searchable()
                    ->limit(40)
                    ->placeholder('Sin asunto'),

                Tables\Columns\TextColumn::make('page.title')
                    ->label('Página')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_read')
                    ->label('Leído')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Estado de lectura')
                    ->placeholder('Todos')
                    ->trueLabel('Leídos')
                    ->falseLabel('No leídos'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Hasta'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from'],
                                fn ($query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['until'],
                                fn ($query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('toggleRead')
                    ->label(fn (FormSubmission $record): string => $record->is_read ? 'Marcar no leído' : 'Marcar leído')
                    ->icon(fn (FormSubmission $record): string => $record->is_read ? 'heroicon-o-envelope' : 'heroicon-o-envelope-open')
                    ->action(function (FormSubmission $record): void {
                        $record->update(['is_read' => !$record->is_read]);
                    }),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markAsRead')
                        ->label('Marcar como leídos')
                        ->icon('heroicon-o-envelope-open')
                        ->action(fn ($records) => $records->each->update(['is_read' => true]))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFormSubmissions::route('/'),
            'view' => Pages\ViewFormSubmission::route('/{record}'),
        ];
    }

    /**
     * Deshabilitar creación — los mensajes solo llegan desde el formulario público.
     */
    public static function canCreate(): bool
    {
        return false;
    }
}
