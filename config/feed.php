<?php

return [

    'feeds' => [
        'main' => [
            'items' => \App\Models\Post::class . '@getFeedItems',
            'url' => '/feed',
            'title' => 'All blogposts',
        ],

        'php' => [
            'items' => \App\Models\Post::class . '@getPhpFeedItems',
            'url' => '/feed/php',
            'title' => 'All blogposts on PHP',
        ],

        'originals' => [
            'items' => \App\Models\Post::class . '@getOriginalContentFeedItems',
            'url' => '/feed/originals',
            'title' => 'All originally written blogposts',
        ],
    ],

];
