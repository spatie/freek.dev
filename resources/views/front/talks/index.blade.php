@extends('front.layouts.master')

@section('title', 'Talks')

@section('content')
    <h1>Talks</h1>

    @foreach($talks as $talk)
        <li class="pb-6 pt-4 border-t list-reset">
             {{ $talk->title }}
            <div class="text-xs text-grey">
                {{ $talk->presented_at->format('M d, Y') }} &nbsp; • &nbsp; {{ $talk->location }} &nbsp; • &nbsp;  {!! $talk->links !!}</div>
        </li>
    @endforeach

@endsection