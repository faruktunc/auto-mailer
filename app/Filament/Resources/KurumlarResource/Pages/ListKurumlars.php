<?php

namespace App\Filament\Resources\KurumlarResource\Pages;

use App\Filament\Resources\KurumlarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKurumlars extends ListRecords
{
    protected static string $resource = KurumlarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
