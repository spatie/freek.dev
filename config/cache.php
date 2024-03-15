<?php

return [
    'default' => env('CACHE_DRIVER', 'file'),

    'stores' => [
        'markdown' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/markdown'),
        ],
    ],

];
