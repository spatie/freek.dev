<?php

namespace App\Http\Controllers;

use App\Models\Post;

class OriginalsController extends Controller
{
    public function __invoke()
    {
        $posts = Post::query()
            ->published()
            ->originalContent()
            ->simplePaginate(50);

        return view('front.originals.index', compact('posts'));
    }
}
