<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class ArchiveController
{
    public function __invoke(): View
    {
        $posts = Post::query()
            ->published()
            ->whereNotNull('publish_date')
            ->get()
            ->groupBy([
                fn (Post $post) => $post->publish_date->format('Y'),
                fn (Post $post) => $post->publish_date->format('F'),
            ]);

        return view('front.pages.archive', compact('posts'));
    }
}
