<?php

use function Laravel\Folio\name;
use function Laravel\Folio\render;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\Ad;

render(function(View $view, Post $post) {
    $ad = Ad::getForCurrentPage();

    abort_unless($post->shouldShow(), 404);

    return $view->with(compact('post', 'ad'));
})->name('post'); ?>

@include('front.posts.show', ['post' => $post])

