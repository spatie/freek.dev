<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'twitter' => [
        'consumer_key' => env('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        'access_token' => env('TWITTER_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
    ],
    'webmentions' => [
        'webhook_secret' => env('WEBMENTIONS_WEBHOOK_SECRET'),
    ],

    'oh_dear' => [
        'backup_run_ping_endpoint' => env('OH_DEAR_BACKUP_PING_ENDPOINT'),
        'publish_scheduled_posts_ping_endpoint' => env('OH_DEAR_PUBLISH_SCHEDULED_POSTS_PING_ENDPOINT'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'media-library' => [
        'salt' => env('MEDIA_LIBRARY_PATH_GENERATOR_SALT'),
    ],

    'flare' => [
        'api_token' => env('FLARE_API_KEY'),
        'project_id' => 271,
    ],

    'mailcoach' => [
        'api_key' => env('MAILCOACH_API_KEY'),
    ],
];
