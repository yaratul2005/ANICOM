<?php

return [
    // default database driver (file or mysql)
    'default' => env('DB_DRIVER', 'file'),

    'connections' => [
        'file' => [
            'driver' => 'file',
            'path' => __DIR__ . '/../anicom-data/',
        ],

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '127.0.0.1'),
            'database'  => env('DB_DATABASE', 'anicom_dev'),
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ],
    ],
];
