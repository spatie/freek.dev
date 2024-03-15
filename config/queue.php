<?php

return [

    'connections' => [
        'mailcoach-redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 11 * 60,
            'block_for' => null,
        ],
    ],

];
