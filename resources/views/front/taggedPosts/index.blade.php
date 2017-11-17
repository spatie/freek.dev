@extends('front.layouts.master')

@section('title', 'Posts tagged "' . $tag->name . '"')

@section('content')
    <h1>Posts tagged {{ $tag->name }}</h1>

    @include('front.posts._partials.list')
@endsection