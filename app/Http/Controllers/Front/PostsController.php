<?php

namespace App\Http\Controllers\Front;

use App\Models\Ad;
use App\Models\Post;
use Illuminate\Routing\Controller;

class PostsController extends Controller
{
    public function detail(Post $post)
    {
        $ad = Ad::getForCurrentPage();

        return view('front.posts.detail', compact('post', 'ad'));
    }
}
