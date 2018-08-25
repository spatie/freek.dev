<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Post;

class PostsController extends Controller
{
    public function detail(Post $post)
    {
        $ad = Ad::getForCurrentPage();

        return view('front.posts.detail', compact('post', 'ad'));
    }
}
