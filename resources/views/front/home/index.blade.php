@extends('front.layouts.master')

@section('title', 'Home')

@section('content')

    @if($onFirstPage)
        <h1>Recent blog entries</h1>
    @else
        <div class="pb-4">
            {{ $posts->links() }}
        </div>
    @endif

    @include('front.posts._partials.list')

    {{ $posts->links() }}
@endsection