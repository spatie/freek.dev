@extends('front.layouts.app')

@section('content')
    @include('front.posts.partials.list')

    {{ $posts->links() }}
@endsection
