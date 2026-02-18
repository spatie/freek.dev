<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class UsesController
{
    public function __invoke(): View
    {
        $post = Post::find(3006);

        if (! $post) {
            return view('front.uses-not-found');
        }

        return redirect()->to($post->url, 301);
    }
}
