<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::published()->orderBy('publish_date', 'desc')->simplePaginate(50);

        $onFirstPage = $posts->onFirstPage();

        return view('front.home.index', compact('posts', 'onFirstPage'));
    }
}
