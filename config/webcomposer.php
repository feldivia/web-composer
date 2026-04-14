<?php

return [
    'fonts' => [
        'Inter', 'Roboto', 'Open Sans', 'Montserrat', 'Poppins',
        'Lato', 'Playfair Display', 'Merriweather', 'Raleway', 'Space Grotesk',
    ],

    'templates' => [
        'path' => database_path('seeders/templates'),
    ],

    'media' => [
        'max_file_size' => env('MEDIA_MAX_FILE_SIZE', 10240),
        'allowed_types' => explode(',', env('MEDIA_ALLOWED_TYPES', 'jpg,jpeg,png,gif,webp,mp4,pdf')),
        'disk' => env('MEDIA_DISK', 'public'),
    ],

    'ai' => [
        'default_provider' => env('AI_DEFAULT_PROVIDER', 'anthropic'),
        'max_tokens' => (int) env('AI_MAX_TOKENS', 2048),
        'rate_limit_per_hour' => (int) env('AI_RATE_LIMIT_PER_HOUR', 50),
    ],
];
