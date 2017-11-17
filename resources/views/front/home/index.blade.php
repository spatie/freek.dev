@extends('front.layouts.master')

@section('title', 'Home')

@section('content')

    @if($onFirstPage)

        <div class="flex flex-col lg:flex-row mb-8">

             {{-- @include('front.home._partials.freek-mini') --}}
        </div>

        <h1>Recent blog entries</h1>
    @else
        <div class="pb-4">
            {{ $posts->links() }}
        </div>
    @endif

    @include('front.posts._partials.list')

    {{ $posts->links() }}
@endsection