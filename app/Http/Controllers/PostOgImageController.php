<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostOgImageController
{
    public function __invoke(Post $post)
    {
        return view('front.posts.ogImage', compact('post'));
    }
}
