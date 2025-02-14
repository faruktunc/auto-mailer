<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('institution_email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurumlars_id')->constrained()->onDelete('cascade'); // Kurumlar tablosuna bağlanıyor
            $table->foreignId('email_id')->constrained('emails')->onDelete('cascade'); // Emails tablosuna bağlanıyor
            $table->timestamp('sent_at')->nullable(); // Gönderim zamanı
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending'); // Durum bilgisi
            $table->text('error_message')->nullable(); // Hata mesajı (varsa)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institution_email_logs');
    }
};
