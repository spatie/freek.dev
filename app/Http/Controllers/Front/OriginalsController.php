<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;

class OriginalsController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->where('original_content', true)
            ->orderBy('publish_date', 'desc')
            ->simplePaginate(50);

        $onFirstPage = $posts->onFirstPage();

        return view('front.originals.index', compact('posts', 'onFirstPage'));
    }
}
