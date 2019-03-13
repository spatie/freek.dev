<?php

namespace App\Http\Controllers;

use App\Models\Post;

class OriginalsController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->published()
            ->orginalContent()
            ->simplePaginate(50);

        $onFirstPage = $posts->onFirstPage();

        return view('front.originals.index', compact('posts', 'onFirstPage'));
    }
}
