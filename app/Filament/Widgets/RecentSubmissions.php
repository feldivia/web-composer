<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\FormSubmissionResource;
use App\Models\FormSubmission;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentSubmissions extends BaseWidget
{
    protected static ?string $heading = 'Mensajes Recientes';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    /**
     * Muestra badge con la cantidad de mensajes no leídos.
     */
    public function getTableHeading(): string
    {
        $unreadCount = FormSubmission::unread()->count();

        if ($unreadCount > 0) {
            return "Mensajes Recientes ({$unreadCount} sin leer)";
        }

        return 'Mensajes Recientes';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FormSubmission::query()
                    ->with('page')
                    ->latest('created_at')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->limit(30)
                    ->placeholder('Sin asunto'),

                Tables\Columns\IconColumn::make('is_read')
                    ->label('Leído')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->url(fn (FormSubmission $record): string => FormSubmissionResource::getUrl('view', ['record' => $record])),
            ])
            ->paginated(false)
            ->emptyStateHeading('Sin mensajes')
            ->emptyStateDescription('Aún no se han recibido mensajes de contacto.');
    }
}
