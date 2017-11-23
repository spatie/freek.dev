@extends('back.layouts.master')

@section('content')

    <div class="bg-white rounded border-2 max-w-xl mx-auto flex-1 my-8 pb-4">
        <div class="flex justify-between items-center bg-grey-lighter mb-2 px-8 py-2 text-grey-darker font-bold">
            <h1 class="p-0 text-grey-darker">Edit Post</h1>
            <a class="bg-blue text-sm text-white hover:text-grey-light py-2 px-3 font-medium rounded-lg" target="_blank" href="{{ $post->url }}">Preview</a>
        </div>
        <form class="mx-8" method="POST" action="{{ action('Back\PostsController@update', $post->id) }}">
            <input type="hidden" name="_method" value="PATCH">

            @include('back.posts._partials.form', ['submitText' => 'Update'])
        </form>
    </div>

@endsection