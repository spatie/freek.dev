<?php

return [
    'default' => env('CACHE_STORE', 'file'),

    'serializable_classes' => false,

    'stores' => [
        'markdown' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/markdown'),
        ],
    ],

];
