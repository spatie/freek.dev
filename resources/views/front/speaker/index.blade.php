@extends('front.layouts.app', [
    'title' => 'Speaker',
])

@section('content')


    <div class="markup">
        <h1>Speaker</h1>
    </div>
    I love public speaking about programming, particulary PHP, Laravel and JavaScript. The past few years I had the honor of speaking at a lot of conferences across the globe.

    Most of my talks are very practical. I like to make people <i>feel</i> how and why a particular solution works. Below you can view videos of my talks. Some are recorded at conferences, some are recorded in the comfort of my own home.

    <div class="markup">
        <h2>Speaking at your event</h2>
    </div>
    If you're considering me to speak at your event you can reach me <a href="mailto:freek@spatie.be">via mail</a>.  I require you to take care of the costs of the flights (or ground transportation) and hotel.

    <div class="markup">
        <h2>Videos</h2>
    </div>
    @foreach($videos as $video)
        @include('front.speaker.partials.video')
    @endforeach
    <div class="markup">
        <h2>Talks</h2>
    </div>
    @foreach($talks as $title => $talks)
        @include('front.speaker.partials.talk')
    @endforeach
@endsection
