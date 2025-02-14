<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurumlar extends Model
{
    protected $fillable = ['kurumAdi', 'kurum_slug', 'kurumEmail'];
    //protected $guarded = [];
    public function emailLogs() {
        return $this->hasMany(InstitutionEmailLog::class, 'kurumlars_id');
    }
}
