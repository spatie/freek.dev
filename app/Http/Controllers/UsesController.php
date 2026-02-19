<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Post;

class UsesController
{
    public function __invoke(): View
    {
        $post = Post::find(3006);

        if (! $post) {
            return view('front.uses-not-found');
        }

        $ad = Ad::getForCurrentPage();

        $previousPost = null;
        $nextPost = null;

        if ($post->publish_date) {
            $previousPost = Post::query()
                ->where('published', true)
                ->where('publish_date', '<', $post->publish_date)
                ->orderBy('publish_date', 'desc')
                ->first();

            $nextPost = Post::query()
                ->where('published', true)
                ->where('publish_date', '>', $post->publish_date)
                ->orderBy('publish_date', 'asc')
                ->first();
        }

        return view('front.posts.show', [
            'post' => $post,
            'ad' => $ad,
            'previousPost' => $previousPost,
            'nextPost' => $nextPost,
            'canonical' => route('uses'),
        ]);
    }
}
