@extends('front.layouts.app', [
    'title' => 'Speaker',
])

@section('content')
    <div class="markup">
        <h1>Videos</h1>
    </div>
    @foreach($videos as $video)
        @include('front.speaker.partials.video')
    @endforeach
    <div class="markup">
        <h1>Talks</h1>
    </div>
    @foreach($talks as $title => $talks)
        @include('front.speaker.partials.talk')
    @endforeach
@endsection
