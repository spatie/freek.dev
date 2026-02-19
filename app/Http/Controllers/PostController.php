<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Post;
use Illuminate\View\View;

class PostController
{
    public function __invoke(Post $post): View
    {
        abort_unless($post->shouldShow(), 404);

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

        $canonical = $post->id === 3006 ? route('uses') : null;

        return view('front.posts.show', compact('post', 'ad', 'previousPost', 'nextPost', 'canonical'));
    }
}
