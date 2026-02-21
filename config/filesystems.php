<?php

return [

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    'disks' => [
        'og-images' => [
            'driver' => 'local',
            'root' => storage_path('og-images'),
            'url' => '/og-images',
        ],

        'admin-uploads' => [
            'driver' => 'local',
            'root' => storage_path('admin-uploads'),
            'url' => env('APP_URL').'/admin-uploads',
            'visibility' => 'public',
        ],

        'avatars' => [
            'driver' => 'local',
            'root' => storage_path('avatars'),
            'url' => env('APP_URL').'/avatars',
            'visibility' => 'public',
        ],
    ],

];
