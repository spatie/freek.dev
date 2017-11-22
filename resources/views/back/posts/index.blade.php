@extends('back.layouts.master')

@section('content')

    <h1 class="lg:-mt-12 lg:mb-4">Posts</h1>

    <div class="flex justify-end">
    <a href="{{ action('Back\PostsController@create') }}" class="bg-green hover:bg-green-dark text-white hover:text-white font-bold py-2 px-4 rounded mb-4">
        New post
    </a>
    </div>

    <table class="posts-table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Publish date</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td><a href="{{ action('Back\PostsController@edit', $post->id) }}">{{ $post->title }}</a></td>
                <td>{{ $post->publish_date }}</td>
                <td>{{ $post->published ? 'Published' : 'Draft' }}</td>
                <td>@include('back._partials.deleteButton', ['url' => action('Back\PostsController@destroy', [$post->id])])</td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection