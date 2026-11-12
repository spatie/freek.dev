<?php

return [
    'default' => env('CACHE_STORE', 'file'),

    'serializable_classes' => false,

    'stores' => [
        'responsecache' => [
            'driver' => 'database',
            'table' => 'response_cache',
        ],

        'markdown' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/markdown'),
        ],
    ],

];
