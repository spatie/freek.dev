@extends('front.layouts.app', [
    'title' => 'Originals',
])

@section('content')
    @include('front.posts.partials.list')

    {{ $posts->links() }}
@endsection
