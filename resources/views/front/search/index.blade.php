@extends('front.layouts.master')

@section('title', 'About')

@section('content')
    <div class="markup">
        <h1>Search</h1>
        <div
            id="search-app"
            data-app-id="{{ config('scout.algolia.id') }}"
            data-api-key="{{ config('scout.algolia.public_key') }}"
            data-index-name="{{ config('scout.algolia.index') }}"
        >
            <input type="search" class="border-b py-1 w-full focus:outline-none focus:border-gray-600" placeholder="Laravel, PHP, JavaScript, …" autofocus>
        </div>
    </div>
@endsection
