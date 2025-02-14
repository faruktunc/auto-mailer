<?php

namespace App\Filament\Resources\AutoMailLogsResource\Pages;

use App\Filament\Resources\AutoMailLogsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAutoMailLogs extends ListRecords
{
    protected static string $resource = AutoMailLogsResource::class;
    protected ?string $subheading = 'Burası sadece otomatik olarak gönderilen mail kayıtlarını içermektedir.';
    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
