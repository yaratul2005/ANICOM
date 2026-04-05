<?php

return [
    'name' => env('APP_NAME', 'ANICOM Store'),
    
    'env' => env('APP_ENV', 'production'),
    
    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'UTC',
    
    'debug' => (bool) env('APP_DEBUG', false),
    
    'active_theme' => env('APP_THEME', 'default'),

    'api_key' => env('API_KEY', ''),
];
