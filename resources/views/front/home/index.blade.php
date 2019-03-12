@extends('front.layouts.master')

@section('title', 'Home')

@section('content')

    @include('front.posts.partials.list')

    {{-- {{ $posts->links() }} --}}
@endsection
