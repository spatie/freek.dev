<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Post;

class PostController extends Controller
{
    public function __invoke(Post $post)
    {
        $ad = Ad::getForCurrentPage();

        return view('front.posts.show', compact('post', 'ad'));
    }
}
