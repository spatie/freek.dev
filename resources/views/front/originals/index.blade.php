@extends('front.layouts.master')

@section('title', 'Original')

@section('content')

    @if($onFirstPage)
        <h1>Originals</h1>
    @else
        <div class="pb-4">
            {{ $posts->links() }}
        </div>
    @endif

    @include('front.posts._partials.list')

    {{ $posts->links() }}
@endsection