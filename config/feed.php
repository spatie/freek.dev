<?php

return [

    'feeds' => [
        'main' => [
            'url' => '/',
            'title' => 'freek.dev - all blogposts',
            'items' => \App\Models\Post::class . '@getFeedItems',
        ],

        'php' => [
            'url' => '/php',
            'title' => 'freek.dev - all php blogposts',
            'items' => \App\Models\Post::class . '@getPhpFeedItems',
        ],

        'originals' => [
            'url' => '/originals',
            'title' => 'freek.dev - all originally written blogposts',
            'items' => \App\Models\Post::class . '@getOriginalContentFeedItems',
        ],
    ],

];
