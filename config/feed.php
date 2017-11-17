<?php

return [

    'feeds' => [
        'main' => [
            'items' => \App\Models\Post::class . '@getFeedItems',
            'url' => '/feed',
            'title' => 'murze.be',
        ],

        'php' => [
            'items' => \App\Models\Post::class . '@getPhpFeedItems',
            'url' => '/feed/php',
            'title' => 'PHP feed murze.be',
        ],
    ],

];
