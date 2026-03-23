<?php

namespace App\Services;

use Illuminate\Validation\Rule;

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
