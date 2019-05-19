@extends('front.layouts.master')

@section('title', 'Home')

@section('content')
    @include('front.posts.partials.list', ['highlightFirstPost' => $onFirstPage])

    {{-- {{ $posts->links() }} --}}
@endsection
