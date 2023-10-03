<?php

use function Laravel\Folio\name;
use function Laravel\Folio\render;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\Ad;

render(function(View $view, Post|string $post) {
    if (is_string($post)) {
        $post = Post::findByIdSlug($post);

        if (! $post) {
            abort(404);
        }
    }

    $ad = Ad::getForCurrentPage();

    abort_unless($post->shouldShow(), 404);

    return $view->with(compact('post', 'ad'));
})->name('post'); ?>

@include('front.posts.show', ['post' => $post])

