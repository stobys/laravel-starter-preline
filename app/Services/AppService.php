<?php

namespace App\Services;

class AppService
{
    public function getAvailableLanguages(): array
    {
        return [
            'en' => 'English',
            'pl' => 'Polski',
            'de' => 'Deutsch',
            // 'fr' => 'French',
            // 'es' => 'Spanish',
        ];
    }
}
