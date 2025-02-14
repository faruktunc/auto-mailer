<?php

namespace App\Filament\Resources\MailSchedulesResource\Pages;

use App\Filament\Resources\MailSchedulesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMailSchedules extends EditRecord
{
    protected static string $resource = MailSchedulesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['paramsaat'] = $this->record->paramsaat;
        $data['paramgun'] = $this->record->paramgun;

        return $data;
    }
}
