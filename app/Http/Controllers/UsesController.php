<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class UsesController
{
    public function __invoke(): View
    {
        $post = Post::find(2357);

        if (! $post) {
            return view('front.uses-not-found');
        }

        return view('front.posts.show', compact('post'));
    }
}
