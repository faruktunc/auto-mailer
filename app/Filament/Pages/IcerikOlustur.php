<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class IcerikOlustur extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Otomatik Mail Oluştur';
    protected static ?string $title = 'İçerik Oluştur';
    protected static string $view = 'filament.pages.icerik-olustur';

}
