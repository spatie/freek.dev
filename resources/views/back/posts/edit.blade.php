@extends('back.layouts.master')

@section('content')

    <h1>{{ $post->name }}</h1>

    <form class="form" method="POST" action="{{ action('Back\PostsController@update', $post->id) }}">
        <input type="hidden" name="_method" value="PATCH">

        @include('back.posts._partials.form', ['submitText' => 'Update'])
    </form>

@endsection