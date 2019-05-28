@extends('front.layouts.master')

@section('title', 'About')

@section('content')
    <div class="markup mb-4">
        <h1>Search</h1>
    </div>
    <div
        id="search-app"
        data-app-id="{{ config('scout.algolia.id') }}"
        data-api-key="{{ config('scout.algolia.public_key') }}"
        data-index-name="{{ config('scout.algolia.index') }}"
    >
        <input
            type="search"
            class="bg-gray-100 px-3 pb-2 pt-3 w-full focus:outline-none border-gray-300 focus:border-gray-400 border-y-2 border-t-transparent"
        >
    </div>
@endsection
