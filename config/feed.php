<?php

return [

    'feeds' => [
        'main' => [
            'items' => \App\Models\Post::class . '@getFeedItems',

            'url' => '',

            'title' => 'murze.be',
        ],
    ],

];
