<?php

use App\Models\Post;

return [
    'feeds' => [
        'main' => [
            'url' => '/',
            'title' => 'freek.dev - all blogposts',
            'items' => [Post::class, 'getFeedItems'],
            'description' => 'All blogposts on freek.dev',
            'language' => 'en-US',
            'format' => 'atom',
            'view' => 'feed::atom',
        ],
        'php' => [
            'url' => '/',
            'title' => 'freek.dev - all PHP blogposts',
            'items' => [Post::class, 'getPhpFeedItems'],
            'description' => 'All PHP blogposts on freek.dev',
            'language' => 'en-US',
            'format' => 'atom',
            'view' => 'feed::atom',
        ],
        'originals' => [
            'url' => '/',
            'title' => 'freek.dev - all originally written blogposts',
            'items' => [Post::class, 'getOriginalContentFeedItems'],
            'description' => 'All originally written blogposts on freek.dev',
            'language' => 'en-US',
            'format' => 'atom',
            'view' => 'feed::atom',
        ],
    ],
];
