@extends('front.layouts.master')

@section('title', 'Talks')

@section('content')
    <h1>Talks</h1>

    @foreach($talks as $talk)
        <li class="pb-6 pt-4 border-t list-reset">
            {{ $talk->presented_at->format('M d, Y') }} - {{ $talk->title }}
            <div> Presented at {{ $talk->location }}</div>
            <div>
                {!! $talk->links !!}
            </div>
        </li>
    @endforeach

@endsection