@extends('front.layouts.master')

@section('title', 'Original')

@section('content')

    <div class="pb-4">
        {{ $posts->links() }}
    </div>

    @include('front.posts.partials.list')

    {{ $posts->links() }}
@endsection
