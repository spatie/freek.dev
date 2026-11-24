<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Post;
use Illuminate\Http\Response;

class PostController
{
    public function __invoke(Post $post): Response
    {
        abort_unless($post->shouldShow(), 404);

        $ad = Ad::getForCurrentPage();

        $previousPost = null;
        $nextPost = null;

        if ($post->publish_date) {
            $previousPost = Post::query()
                ->where('published', true)
                ->where('archived', false)
                ->where('publish_date', '<', $post->publish_date)
                ->orderBy('publish_date', 'desc')
                ->first();

            $nextPost = Post::query()
                ->where('published', true)
                ->where('archived', false)
                ->where('publish_date', '>', $post->publish_date)
                ->orderBy('publish_date', 'asc')
                ->first();
        }

        $canonical = match (true) {
            $post->id === 3006 => route('uses'),
            $post->id === 2918, $post->archived => $post->url,
            default => null,
        };

        return response()->view('front.posts.show', compact('post', 'ad', 'previousPost', 'nextPost', 'canonical'))
            ->withHeaders($post->archived ? ['site-search-do-not-index' => 'true'] : []);
    }
}
