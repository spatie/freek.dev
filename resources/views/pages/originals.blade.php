<?php

use function Laravel\Folio\render;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\Ad;

render(function (View $view) {
    $posts = Post::query()
        ->published()
        ->originalContent()
        ->simplePaginate(20);

    $view->with(compact('posts'));
}); ?>

<x-app-layout title="Originals">
    <div
        class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 mb-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700">

        <p>
            In this section you can read posts I've written myself.
        </p>
    </div>

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
