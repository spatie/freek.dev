@extends('front.layouts.master')

@section('title', 'Originals')

@section('content')
    @include('front.posts.partials.list')

    {{ $posts->links() }}
@endsection
