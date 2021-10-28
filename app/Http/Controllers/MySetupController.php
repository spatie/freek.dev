<?php

namespace App\Http\Controllers;

use App\Models\Post;

class MySetupController
{
    public function __invoke()
    {
        $post = Post::find('2119');

        return view('front.posts.show', compact('post'));
    }
}
