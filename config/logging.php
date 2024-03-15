<?php

return [

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    'channels' => [
        'flare' => [
            'driver' => 'flare',
        ],
    ],

];
