<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController
{
    public function __invoke()
    {
        $posts = Post::query()
            ->published()
            ->simplePaginate(20);

        return view('front.home.index', compact('posts'));
    }
}
