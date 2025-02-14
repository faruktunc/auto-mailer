<?php

namespace App\Filament\Resources\MailSchedulesResource\Pages;

use App\Filament\Resources\MailSchedulesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMailSchedules extends ListRecords
{
    protected static string $resource = MailSchedulesResource::class;
    protected ?string $subheading = 'Otomatik olarak gönderilmesi planlanan mailler';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
