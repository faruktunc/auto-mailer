<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lorisleiva\CronTranslator\CronTranslator;

class MailSchedules extends Model
{
    protected $guarded = [];

    public function getCronExpressionAttribute()
    {
        switch ($this->frequency) {
            case 'at':
                [$hour, $minute] = explode(':', $this->params);
                return "$minute $hour * * *";

            case 'hourly':
                return "0 * * * *";

            case 'weeklyOn':
                [$day, $time] = explode(',', $this->params);
                [$hour, $minute] = explode(':', $time);
                return "$minute $hour * * $day";

            default:
                return "* * * * *"; // Varsayılan her dakika çalıştır
        }
    }

    public function getCronTelaffuzAttribute()
    {
        $expression = $this->CronExpression;
        return CronTranslator::translate($expression, 'tr', true);
    }

    public function getParamsaatAttribute()
    {
        if ($this->params) {
            $degerler = explode(',', $this->params);
            if (isset($degerler[1])) {
                return $degerler[1];
            } else {
                return $degerler[0];
            }
        }else{
            return null;
        }

    }

    public function getParamgunAttribute()
    {
        return $this->params ? explode(',', $this->params)[0] : null;
    }


}
