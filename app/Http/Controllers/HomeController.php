<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->published()
            ->orderBy('publish_date', 'desc')
            ->orderBy('id', 'desc')
            ->simplePaginate(20);

        $firstOriginal = Post::query()
            ->published()
            ->where('original_content', true)
            ->orderBy('publish_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $posts = $posts->reject(function (Post $post) use ($firstOriginal) {
            return $post->is($firstOriginal);
        })->prepend($firstOriginal);

        $onFirstPage = false;//$posts->onFirstPage();

        return view('front.home.index', compact('posts', 'onFirstPage'));
    }
}
