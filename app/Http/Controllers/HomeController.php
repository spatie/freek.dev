<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class HomeController
{
    public function __invoke(): View
    {
        $posts = Post::query()
            ->published()
            ->simplePaginate(20);

        return view('front.pages.home', compact('posts'));
    }
}
