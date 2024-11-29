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
        'scheme' => 'https',
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
        'email_list_uuid' => env('MAILCOACH_EMAIL_LIST_UUID'),
    ],

    'bluesky' => [
        'username' => env('BLUESKY_USERNAME'),
        'password' => env('BLUESKY_PASSWORD'),
    ],
];
