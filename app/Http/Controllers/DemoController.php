<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class DemoController
{
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->simplePage(10);

        return view('front.pages.demo', compact('posts'));
    }
}
