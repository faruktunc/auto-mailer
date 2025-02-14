<?php

namespace App\Livewire;

use App\Filament\Resources\MailSchedulesResource;
use App\Models\Email;
use App\Models\Kurumlar;
use App\Models\MailSchedules;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Support\MessageBag;
use Livewire\Component;

class CreateAutoMail extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->description('Email Planlamanızı bu formdan sağlayın')
                    ->schema([
                        Radio::make('mailtercihi')->options([
                            'template' => 'Şablondan seç',
                            'make' => 'Kendin yaz'
                        ])->default('template')->required()->live()->label('Email Tercihiniz'),

                        Select::make('hazirsablonlar')->options(Email::all()->pluck('subject', 'id'))->required()
                            ->live()
                            ->visible(fn(Get $get) => $get('mailtercihi') == 'template')->label('Hazır Şablonlarınız'),

                        Section::make('Şablon Önizlemesi')
                            ->description('Seçtiğiniz Şablonun görünümü aşağıdaki gibidir. Parametreler mail gönderildikten sonra değiştirilecektir.')
                            ->schema([
                                Placeholder::make('template_preview')
                                    ->label('Şablon Önizlemesi')->hiddenLabel()
                                    ->content(fn(Get $get) => Email::find($get('hazirsablonlar'))?->body ? new HtmlString(Email::find($get('hazirsablonlar'))?->body) : 'Henüz bir şablon seçilmedi.')
                                    ->visible(fn(Get $get) => $get('mailtercihi') == 'template'),

                            ])->visible(fn(Get $get) => $get('mailtercihi') == 'template'),

                        TextInput::make('title')
                            ->visible(fn(Get $get) => $get('mailtercihi') == 'make')
                            ->required()->label('Başlık'),
                        MarkdownEditor::make('content')->label('İçerik')->required()
                            ->visible(fn(Get $get) => $get('mailtercihi') == 'make'),
                        Select::make('gonderilecekler')
                            ->required()
                            ->multiple()
                            ->searchable()
                            ->options(Kurumlar::all()->pluck('kurumAdi', 'id'))->label('Hedef Emailler'),
                        // TextInput::make('cron')->label('Cron açıklaması')->placeholder('* * * * *')
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




                    ]),


            ])->statePath('data');
    }

    public function create()
    {
        $all = $this->form->getState();
        if ($all['mailtercihi']=='template'){
            $gonderilecekOlanMail= $this->tercihEdilenYontemTemplate($all['hazirsablonlar']);
            $all['title'] = $gonderilecekOlanMail->subject;
            $all['content'] = $gonderilecekOlanMail->body;
            //dd($gonderilecekOlanMail);
        }


        if(isset($all['frequency'])) {
            if ($all['frequency'] == 'weeklyOn') {
                $all['params'] = $all['paramgun'] . ',' . $all['paramsaat'];
            }
            if ($all['frequency'] == 'at'){
                $all['params'] = $all['paramsaat'];
            }
        }
        if (!isset($all['params'])){
            $all['params']=null;
        }

        $a = array();
        foreach ($all['gonderilecekler'] as $kurumid) {
            if ($kurumid) {
                $mail = $this->degiskencozumleyici($all['title'], $kurumid, $all['content']);
                //$this->gonderParametreli($mail[0], $mail[1], $mail[2]);
                $planlananmail= $this->store($mail[0],$mail[1],$mail[2],$all['frequency'],$all['params']);
                array_push($a, $mail[0]);

            }
            $b = implode("<br>", $a);

        }
        Notification::make()
            ->title('Başarıyla Planlandı')
            ->icon('heroicon-o-paper-airplane')
            ->success()
            ->send();
        return redirect()->to(MailSchedulesResource::getUrl());
    }

    public function render()
    {
        return view('livewire.create-auto-mail');
    }
    private function tercihEdilenYontemTemplate($id){
        return Email::find($id);
    }
    private function store($hedefmail,$baslik,$icerik,$frequency,$params){
        return MailSchedules::create([
            'hedefmail' => $hedefmail,
            'baslik' => $baslik,
            'icerik' => $icerik,
            'frequency' => $frequency,
            'params' => $params,
        ]);
    }

    private function degiskencozumleyici($metin, $kurumid, $baslik)
    {
        $kurum = Kurumlar::find($kurumid);
        $tempmetin = str_replace('$kurumAdi', $kurum->kurumAdi, $metin);
        $tempbaslik = str_replace('$kurumAdi', $kurum->kurumAdi, $baslik);
        return [$kurum->kurumEmail, $tempmetin, $tempbaslik];
    }
}
