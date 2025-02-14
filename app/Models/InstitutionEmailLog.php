<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionEmailLog extends Model
{
    protected $fillable = [
        'kurumlars_id',
        'email_id',
        'sent_at',
        'status',
        'error_message'
    ];

    public function kurum() {
        return $this->belongsTo(Kurumlars::class, 'kurumlars_id');
    }

    public function email() {
        return $this->belongsTo(Email::class, 'email_id');
    }
}
