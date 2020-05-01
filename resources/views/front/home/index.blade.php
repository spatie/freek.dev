@extends('front.layouts.app')

@section('content')
    <x-ad />

    @include('front.posts.partials.list')

    {{ $posts->links() }}
@endsection
