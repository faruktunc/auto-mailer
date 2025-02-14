<?php

return [
    'extended' => [
        '@reboot' => 'başlangıçta bir kez çalıştır',
    ],
    'minutes' => [
        'every' => 'her dakika',
        'increment' => 'her :increment dakika',
        'times_per_increment' => ':increment dakikada :times kez',
        'multiple' => 'saatte :times kez',
    ],
    'hours' => [
        'every' => 'her saat',
        'once_an_hour' => 'saatte bir kez',
        'increment' => 'her :increment saat',
        'multiple_per_increment' => ':increment saat içinde :count saat',
        'times_per_increment' => 'her :increment saatte :times kez',
        'increment_chained' => 'her :increment saatte bir',
        'multiple_per_day' => 'günde :count saat',
        'times_per_day' => 'günde :times kez',
        'once_at_time' => ':time saatinde',
    ],
    'days_of_month' => [
        'every' => 'her gün',
        'increment' => 'her :increment gün',
        'multiple_per_increment' => ':increment gün içinde :count gün',
        'multiple_per_month' => 'ayda :count gün',
        'once_on_day' => ':day gününde',
        'every_on_day' => 'her ayın :day gününde',
    ],
    'months' => [
        'every' => 'her ay',
        'every_on_day' => 'her ayın :day günü',
        'increment' => 'her :increment ay',
        'multiple_per_increment' => ':increment ay içinde :count ay',
        'multiple_per_year' => 'yılda :count ay',
        'once_on_month' => ':month ayında',
        'once_on_day' => ':month ayının :day günü',
    ],
    'days_of_week' => [
        'every' => 'her :weekday',
        'increment' => 'her :increment hafta günü',
        'multiple_per_increment' => ':increment hafta günü içinde :count gün',
        'multiple_days_a_week' => 'haftada :count gün',
        'once_on_day' => ':days gününde',
    ],
    'years' => [
        'every' => 'her yıl',
    ],
    'times' => [
        'am' => 'öö',
        'pm' => 'ös',
    ],
];
