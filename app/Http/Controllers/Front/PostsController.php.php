<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Routing\Controller;

class PostsController extends Controller
{
    public function detail(Post $post)
    {
        return view('front.posts.detail', compact('post'));
    }
}
