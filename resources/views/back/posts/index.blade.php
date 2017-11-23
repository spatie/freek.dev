@extends('back.layouts.master')

@section('content')

    <div class="bg-white rounded border-2 max-w-xl mx-auto flex-1 my-8 pb-4">
        <div class="flex justify-between items-center bg-grey-lighter mb-2 px-8 py-2 text-grey-darker font-bold">
            <h1 class="p-0 text-grey-darker">Posts</h1>
            <a href="{{ action('Back\PostsController@create') }}" class="bg-blue text-sm text-white hover:text-grey-light py-2 px-3 font-medium rounded-lg">
                New Post
            </a>
        </div>

        @foreach($posts as $post)
            <div class="flex justify-between items-start px-6 py-2 border-b border-grey-lighter">
                <div>
                    <div>
                        <a href="{{ action('Back\PostsController@edit', $post->id) }}">{{ $post->title }}</a>
                    </div>
                    <div class="text-xs text-grey font-medium">
                        {{ $post->publish_date }}
                    </div></div>
                <div class="flex justify-between items-center">
                    <div class="text-sm my-1 px-2 border-r {{ $post->published ? 'text-green' : 'text-orange' }}">{{ $post->published ? 'Published' : 'Draft' }}</div>
                    <div class="text-sm my-1 px-2">@include('back._partials.deleteButton', ['url' => action('Back\PostsController@destroy', [$post->id])])</div>
                </div>
            </div>
        @endforeach
    </div>

@endsection