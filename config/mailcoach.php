<?php

return [
    'throttling' => [
        'enabled' => true,
        'redis_connection_name' => 'default',
        'redis_key' => 'laravel-mailcoach',
        'allowed_number_of_jobs_in_timespan' => 10,
        'timespan_in_seconds' => 1,
        'release_in_seconds' => 5,
    ],

    'editor' => \Spatie\MailcoachMonaco\MonacoEditor::class,

    'mailgun_feedback' => [
        'signing_secret' => env('MAILGUN_SIGNING_SECRET'),
    ],

    'monaco' => [
        'theme' => 'vs-light',
        'fontFamily' => '"Courier New", Courier, monospace',
        'fontLigatures' => true,
        'fontWeight' => 400,
        'fontSize' => '16',
        'lineHeight' => '30'
    ],
];
