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

        return view('front.posts.show', compact('post', 'ad'));
    }
}
