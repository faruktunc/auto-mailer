<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Email extends Model
{
    protected $fillable = ['subject','body','mailtercihi'];
    public function institutionLogs() {
        return $this->hasMany(InstitutionEmailLog::class, 'email_id');
    }
    public function kurumlar(): BelongsToMany
    {
        return $this->belongsToMany(Kurumlar::class, 'institution_email_logs', 'email_id', 'kurumlars_id')
            ->withPivot('sent_at', 'status', 'error_message')
            ->withTimestamps();
    }
}
