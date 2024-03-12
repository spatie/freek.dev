<?php

return [

    'mailers' => [
        'mailcoach' => [
            'transport' => 'mailcoach',
            'domain' => env('MAILCOACH_DOMAIN'),
            'token' => env('MAILCOACH_TOKEN'),
        ],

        'mailgun' => [
            'transport' => 'mailgun',
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],
    ],

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
