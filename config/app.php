<?php

return [
    // -- Application Name
    'name' => env('APP_NAME', 'Laravel'),

    // -- Application Environment
    'env' => env('APP_ENV', 'production'),

    // -- Application Debug Mode
    'debug' => (bool) env('APP_DEBUG', false),

    // -- Application URL
    'url' => env('APP_URL', 'http://localhost'),

    // -- Application Timezone
    'timezone' => 'UTC',

    // -- Application Locale Configuration
    'locale' => env('APP_LOCALE', 'en'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    // -- Encryption Key
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    // -- Maintenance Mode Driver
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    // -- Paginator Config
    'paginator' => [
        'items_per_page' => 10,
        'on_each_side'  => 3,
    ],
];
