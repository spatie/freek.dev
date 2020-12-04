<?php

namespace App\Http\Controllers;

use App\Models\Post;

class MySetupController
{
    public function __invoke()
    {
        $post = Post::find('1844');

        return view('front.posts.show', compact('post'));
    }
}
