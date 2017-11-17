@extends('back.layouts.master')

@section('content')

    <h1>Posts</h1>

    <a href="{{ action('Back\PostsController@create') }}" class="bg-green hover:bg-green-dark text-white font-bold py-2 px-4 rounded">
        New post
    </a>

    <table>
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