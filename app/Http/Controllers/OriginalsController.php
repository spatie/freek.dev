<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class OriginalsController
{
    public function __invoke(): View
    {
        $posts = Post::query()
            ->published()
            ->originalContent()
            ->simplePaginate(20);

        return view('front.pages.originals', compact('posts'));
    }
}
