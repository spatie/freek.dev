<?php

use App\Models\Post;
use Illuminate\View\View;
use function Laravel\Folio\render;

render(function(View $view) {
    $post = Post::find(2357);

    $view->with(compact('post'));
}); ?>

@include('front.posts.show', ['post' => $post])


