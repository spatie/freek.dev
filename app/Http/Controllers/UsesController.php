<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class UsesController
{
    public function __invoke()
    {
        $post = Post::find(3006);

        if (! $post) {
            return view('front.uses-not-found');
        }

        return redirect(route('post', ['post' => $post->idSlug()]), 301);
    }
}
