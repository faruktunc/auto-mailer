<?php

namespace App\Console\Commands;

use App\Mail\IsBasvuru;
use App\Models\AutoMailLogs;
use App\Models\MailSchedules;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailGonder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jotform:mail-gonder
                            {hedefotomailId : Hedef Oto mail id}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Maili Gönderir ve loga kaydeder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gonderilecekOtoMail = MailSchedules::find($this->argument('hedefotomailId'));
        Mail::to($gonderilecekOtoMail->hedefmail)->send(new IsBasvuru($gonderilecekOtoMail->baslik,$gonderilecekOtoMail->icerik));
        AutoMailLogs::create([
            'gonderilenEmail' => $gonderilecekOtoMail->hedefmail,
            'baslik' => $gonderilecekOtoMail->baslik,
            'icerik' => $gonderilecekOtoMail->icerik,
            'gonderimTarihi' => now()
        ]);

        $this->info('Mail başarıyla '.
            $gonderilecekOtoMail->hedefmail
            ."'a gönderildi.");
    }
}
