<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            'en' => 'English',
            'fr' => 'French',
            'es' => 'Spanish',
            'ar' => 'Arabic',
            'cmn' => 'Mandarin',
            'ru' => 'Russian',
            'pt' => 'Portuguese',
            'de' => 'German',
            'ja' => 'Japanese',
            'hi' => 'Hindi',
            'ms' => 'Malay',
            'fa' => 'Persian',
            'sw' => 'Swahili',
            'ta' => 'Tamil',
            'it' => 'Italian',
            'nl' => 'Dutch',
            'bn' => 'Bengali',
            'tr' => 'Turkish',
            'vi' => 'Vietnamese',
            'pl' => 'Polish',
            'jv' => 'Javanese',
            'pa' => 'Punjabi',
            'th' => 'Thai',
            'ko' => 'Korean'
        ];
        foreach ($languages as $code => $name) {
            Language::create(compact('name', 'code'));
        }
    }
}
