<?php

return [

    'feeds' => [
        'main' => [
            'url' => '/feed',
            'title' => 'murze.be - all blogposts',
            'items' => \App\Models\Post::class . '@getFeedItems',
        ],

        'php' => [
            'url' => '/feed/php',
            'title' => 'murze.be - all php blogposts',
            'items' => \App\Models\Post::class . '@getPhpFeedItems',
        ],

        'originals' => [
            'url' => '/feed/originals',
            'title' => 'murze.be - all originally written blogposts',
            'items' => \App\Models\Post::class . '@getOriginalContentFeedItems',
        ],
    ],

];
