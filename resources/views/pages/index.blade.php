<?php

use function Laravel\Folio\render;
use App\Models\Post;
use Illuminate\View\View;

render(function (View $view) {
    $posts = Post::query()
        ->published()
        ->simplePaginate(20);

    $view->with(compact('posts'));
}); ?>

<x-app-layout>
    <x-ad/>

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
