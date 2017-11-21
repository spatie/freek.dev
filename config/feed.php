<?php

return [

    'feeds' => [
        'main' => [
            'items' => \App\Models\Post::class . '@getFeedItems',
            'url' => '/feed',
            'title' => 'murze.be - all blogposts',
        ],

        'php' => [
            'items' => \App\Models\Post::class . '@getPhpFeedItems',
            'url' => '/feed/php',
            'title' => 'murze.be - all php blogposts',
        ],

        'originals' => [
            'items' => \App\Models\Post::class . '@getOriginalContentFeedItems',
            'url' => '/feed/originals',
            'title' => 'murze.be - all originally written blogposts',
        ],
    ],

];
