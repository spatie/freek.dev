<?php

return [

    'twitter' => [
        'consumer_key' => env('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        'access_token' => env('TWITTER_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
    ],

    'mastodon' => [
        'token' => env('MASTODON_TOKEN'),
    ],

    'oh_dear' => [
        'pulse' => [
            'api_key' => env('OH_DEAR_API_TOKEN'),
            'site_id' => env('OH_DEAR_SITE_ID'),
        ],
        'backup_run_ping_endpoint' => env('OH_DEAR_BACKUP_PING_ENDPOINT'),
        'publish_scheduled_posts_ping_endpoint' => env('OH_DEAR_PUBLISH_SCHEDULED_POSTS_PING_ENDPOINT'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
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
        'pulse' => [
            'api_key' => env('MAILCOACH_API_TOKEN'),
            'api_endpoint' => env('MAILCOACH_API_ENDPOINT'),
            'email_list_uuid' => env('MAILCOACH_EMAIL_LIST_UUID'),
        ],

        'api_key' => env('MAILCOACH_API_TOKEN'),
        'email_list_uuid' => env('MAILCOACH_EMAIL_LIST_UUID'),
    ],
];
