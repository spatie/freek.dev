<?php

namespace App\Http\Controllers\Discovery;

use Illuminate\View\View;
use App\Models\Post;
use function view;

class OriginalsController
{
    public function __invoke(): View
    {
        $posts = Post::query()
            ->published()
            ->originalContent()
            ->simplePaginate(20);

        return view('front.originals.index', compact('posts'));
    }
}
