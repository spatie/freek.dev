@extends('front.layouts.master')

@section('title', 'About')

@section('content')
    <div
        id="search-app"
        data-app-id="{{ config('scout.algolia.id') }}"
        data-api-key="{{ config('scout.algolia.public_key') }}"
        data-index-name="{{ config('scout.algolia.index') }}"
    >
        <input
            type="search"
            class="bg-gray-200 rounded p-2 w-full focus:outline-none focus:border-gray-600"
            placeholder="Search"
        >
    </div>
@endsection
