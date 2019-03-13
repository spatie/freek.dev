<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = $this->getPosts();

        $onFirstPage = $posts->onFirstPage();

        return view('front.home.index', compact('posts', 'onFirstPage'));
    }

    protected function getPosts()
    {
        $lastestOriginal = Post::query()
            ->published()
            ->originalContent()
            ->first();

        $posts = Post::query()
            ->published()
            ->where('id', '<>', $lastestOriginal->id)
            ->simplePaginate(20);

        if ($posts->onFirstPage()) {
            $posts->prepend($lastestOriginal);
        }

        return $posts;
    }
}
