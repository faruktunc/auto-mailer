<?php

namespace App\Filament\Widgets;

use App\Models\Email;
use App\Models\Kurumlar;
use App\Models\MailSchedules;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $activeplanlanan = MailSchedules::where('active', true)->count();
        $kurum_kisi = Kurumlar::all()->count();
        $sablonlar = Email::all()->count();

        return [
            Stat::make('Aktif planlanan emailler', $activeplanlanan.' adet')->icon('heroicon-o-clock'),
               // ->descriptionIcon('heroicon-m-document-text', IconPosition::Before)

            Stat::make('Kurum & Kişi sayısı', $kurum_kisi.' adet')->icon('heroicon-o-users'),
            Stat::make('Email Şablonu', $sablonlar. ' adet')->icon('heroicon-o-document-plus'),
        ];
    }
}
