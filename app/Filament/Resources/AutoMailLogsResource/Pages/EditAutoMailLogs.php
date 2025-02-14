<?php

namespace App\Filament\Resources\AutoMailLogsResource\Pages;

use App\Filament\Resources\AutoMailLogsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAutoMailLogs extends EditRecord
{
    protected static string $resource = AutoMailLogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
