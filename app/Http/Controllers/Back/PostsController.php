<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('publish_date', 'desc')->get();

        return view('back.posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post();

        $post->publish_date = now();

        return view('back.posts.create', compact('post'));
    }

    public function store(PostRequest $request)
    {
        $post = (new Post())->updateAttributes($request->validated());

        flash()->success('Post saved');

        return redirect()->action('Back\PostsController@edit', $post->id);
    }

    public function edit(Post $post)
    {
        return view('back.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->updateAttributes($request->validated());

        flash()->success('Post updated');

        return redirect()->action('Back\PostsController@edit', $post->id);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        flash()->success('The post was deleted');

        return redirect()->action('Back\PostsController@index');
    }
}
