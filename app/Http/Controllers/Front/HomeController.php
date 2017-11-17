<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::published()->orderBy('publish_date', 'desc')->simplePaginate(50);

        $onFirstPage = $posts->onFirstPage();

        return view('front.home.index', compact('posts', 'onFirstPage'));
    }
}
