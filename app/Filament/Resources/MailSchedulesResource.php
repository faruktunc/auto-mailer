<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MailSchedulesResource\Pages;
use App\Filament\Resources\MailSchedulesResource\RelationManagers;
use App\Models\MailSchedules;
use App\Schedule\CronSchedule;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Lorisleiva\CronTranslator\CronTranslator;

class MailSchedulesResource extends Resource
{
    protected static ?string $model = MailSchedules::class;
    protected static ?string $label = 'Planlanmış Mail';
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Planlanmış Mailler';
    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('frequency')
                ->label('Gönderim Sıklığı')
                ->options([
                    'hourly' => 'Saatlik',
                    'at' => 'Günlük',
                    'weeklyOn' => 'Haftalık',
                    // 'monthly' => 'Aylık',
                ])
                ->live()
                ->default('hourly') // Varsayılan olarak günlük seçili gelir
                ->required()
                ->reactive(),

            TimePicker::make('paramsaat')
                ->label('Gönderim Saati')
                ->format('H:i')
                ->required()
                ->visible(fn($get) => in_array($get('frequency'), ['at', 'weeklyOn', 'monthly'])),

            Select::make('paramgun')
                ->label('Haftanın Günü')
                // ->multiple()
                ->options([
                    1 => 'Pazartesi',
                    2 => 'Salı',
                    3 => 'Çarşamba',
                    4 => 'Perşembe',
                    5 => 'Cuma',
                    6 => 'Cumartesi',
                    7 => 'Pazar',
                ])
                ->visible(fn($get) => $get('frequency') === 'weeklyOn')
                ->required(fn($get) => $get('frequency') === 'weeklyOn'),


        ]);
    }


    public static function table(Table $table): Table
    {


        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hedefmail')->label('Gönderilecek Mail'),
                Tables\Columns\TextColumn::make('CronTelaffuz')->label('Gönderim Planı'),
                Tables\Columns\ToggleColumn::make('active')->label('Aktiflik'),

            ])
            ->filters([

            ])
            ->actions([

                Tables\Actions\Action::make('viewMail')
                    ->label('Planlanan Emaili Görüntüle')
                    ->modal()
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn($action) => $action->label('Kapat'))
                    ->modalContent(fn(MailSchedules $record) => view('modal.mailGoruntuleModal', ['record' => $record])),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->fillForm(function (MailSchedules $record, array $data): array {
                        //dd($record);
                        $data['frequency'] = $record->frequency;
                        $data['paramsaat'] = $record->paramsaat;
                        $data['paramgun'] = $record->paramgun;

                        return $data;
                    })->using(function (MailSchedules $record, array $data): MailSchedules {
                        if (isset($data['paramsaat'])) {
                            $record->update([
                                    'frequency' => $data['frequency'],
                                    'params' => isset($data['paramgun']) ? $data['paramgun'] . ',' . $data['paramsaat'] : $data ['paramsaat'],
                                ]
                            );
                        } else {
                            $record->update([
                                'frequency' => $data['frequency'],
                                'params' => null
                            ]);
                        }
                        return $record;

                    })->successNotificationTitle('Planlanan Zaman Güncellendi'),
                    Tables\Actions\DeleteAction::make(),
                ]),


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
            'index' => Pages\ListMailSchedules::route('/'),
            //'create' => Pages\CreateMailSchedules::route('/create'),
            //'edit' => Pages\EditMailSchedules::route('/{record}/edit'),
        ];
    }
}
