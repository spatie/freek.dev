@extends('front.layouts.app', [
    'title' => 'Search',
])

@php($livewire = true)

@section('content')
    <div class="markup mb-4">
        <h1>Search</h1>
    </div>

    @livewire('search')

@endsection
