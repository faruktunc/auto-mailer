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
        Schema::create('mail_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('hedefmail');
            $table->string('baslik');
            $table->longText('icerik');
            $table->string('frequency');
            $table->string('params')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_schedules');
    }
};
