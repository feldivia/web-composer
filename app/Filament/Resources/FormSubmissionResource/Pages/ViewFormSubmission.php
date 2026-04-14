<?php

declare(strict_types=1);

namespace App\Filament\Resources\FormSubmissionResource\Pages;

use App\Filament\Resources\FormSubmissionResource;
use App\Models\FormSubmission;
use Filament\Resources\Pages\ViewRecord;

class ViewFormSubmission extends ViewRecord
{
    protected static string $resource = FormSubmissionResource::class;

    /**
     * Marca automáticamente como leído al ver el detalle.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var FormSubmission $record */
        $record = $this->getRecord();

        if (!$record->is_read) {
            $record->update(['is_read' => true]);
        }

        return $data;
    }
}
