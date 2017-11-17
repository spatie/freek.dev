@extends('back.layouts.master')

@section('content')

    <h1>New post</h1>

    <form class="form" action="{{ action('Back\PostsController@store') }}" method="POST">
        @include('back.posts._partials.form', ['submitText' => 'Create'])
    </form>

@endsection