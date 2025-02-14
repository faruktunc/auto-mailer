<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AutoMailLogsResource\Pages;
use App\Filament\Resources\AutoMailLogsResource\RelationManagers;
use App\Models\AutoMailLogs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class AutoMailLogsResource extends Resource
{
    protected static ?string $model = AutoMailLogs::class;
    protected static ?string $label = 'Otomatik Gönderilen Email Kayıtları';
    
    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?string $navigationLabel = 'Otomatik Mail - Loglar';
    protected static ?int $navigationSort = 5;

    public static function canCreate(): bool
    {

        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gonderilenEmail')->label('Alıcı email'),
                Tables\Columns\TextColumn::make('gonderimTarihi')->label('Gönderim Tarihi')
            ])
            ->filters([
                Tables\Filters\Filter::make('gonderilenEmail')
                    ->form([Forms\Components\TextInput::make('gonderilenEmail')->label('Alıcı email')])
                    ->query(fn(Builder $query, array $data) => $query->where('gonderilenEmail', 'like', '%' . $data['gonderilenEmail'] . '%')),

                DateRangeFilter::make('gonderimTarihi')->label('Gönderim Tarihi')
            ], layout: Tables\Enums\FiltersLayout::AboveContent)->filtersFormColumns(2)
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('viewMail')
                    ->label('Gönderilen Emaili Görüntüle')
                    ->modal()
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn($action) => $action->label('Kapat'))
                    ->modalContent(fn(AutoMailLogs $record) => view('modal.mailGoruntuleModal', ['record' => $record]))
            ])
            ->bulkActions([

            ])->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAutoMailLogs::route('/'),
            'create' => Pages\CreateAutoMailLogs::route('/create'),
            'edit' => Pages\EditAutoMailLogs::route('/{record}/edit'),
        ];
    }
}
