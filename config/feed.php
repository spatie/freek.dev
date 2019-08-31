<?php

return [

    'feeds' => [
        'main' => [
            'url' => '/feed',
            'title' => 'freek.dev - all blogposts',
            'items' => \App\Models\Post::class . '@getFeedItems',
        ],

        'php' => [
            'url' => '/feed/php',
            'title' => 'freek.dev - all php blogposts',
            'items' => \App\Models\Post::class . '@getPhpFeedItems',
        ],

        'originals' => [
            'url' => '/feed/originals',
            'title' => 'freek.dev - all originally written blogposts',
            'items' => \App\Models\Post::class . '@getOriginalContentFeedItems',
        ],
    ],

];
