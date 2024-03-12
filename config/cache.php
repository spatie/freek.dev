<?php

use Illuminate\Support\Str;

return [

    'stores' => [
        'markdown' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/markdown'),
        ],
    ],

];
