<?php

namespace App\Http\Controllers\Discovery;

use App\Models\Post;
use function view;

class UsesController
{
    public function __invoke()
    {
        $post = Post::find('2357');

        return view('front.posts.show', compact('post'));
    }
}
