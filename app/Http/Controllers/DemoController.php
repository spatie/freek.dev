<?php

namespace App\Http\Controllers;

use App\Models\Post;

class DemoController
{
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->simplePaginate(10);

        return view('front.pages.demo', compact('posts'));
    }
}
