<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Post;

class PostsController extends Controller
{
    public function show(Post $post)
    {
        $ad = Ad::getForCurrentPage();

        return view('front.posts.show', compact('post', 'ad'));
    }
}
