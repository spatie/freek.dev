<?php

use Illuminate\View\View;
use App\Models\Talk;
use App\Models\Video;
use function Laravel\Folio\render;

render(function(View $view) {
    $talks = Talk::orderBy('presented_at', 'desc')
        ->get()
        ->groupBy('title');

    $videos = Video::latest()->get();

    $view->with(compact('talks', 'videos'));
});
?>

<x-app-layout title="Speaking">
    <div class="markup | mb-8">
        <h1>Speaking</h1>
        <p>
            I love public speaking about programming, particulary PHP, Laravel and JavaScript. The past few years I had the honor of speaking at a lot of conferences across the globe.
        </p>
        <p>
            Most of my talks are very practical. I like to make people <i>feel</i> how and why a particular solution works. Below you can view videos of my talks. Some are recorded at conferences, some are recorded in the comfort of my own home.
        </p>
        <h2 id="speaking-at-your-event">
            Speaking at your event
            <a href="#speaking-at-your-event" class="permalink">#</a>
        </h2>
        <p>
            If you're considering me to speak at your event you can reach me <a href="mailto:freek@spatie.be">via mail</a>. I require you to take care of the costs of the flights (or ground transportation) and hotel.
        </p>

        <h2 id="highlights">
            Highlights
            <a href="#highlights" class="permalink">#</a>
        </h2>
    </div>

    @foreach($videos as $video)
        @include('front.speaking.partials.video')
    @endforeach

    <div class="markup">
        <h2 id="all-talks">
            All talks
            <a href="#all-talks" class="permalink">#</a>
        </h2>
    </div>
    @foreach($talks as $title => $talks)
        @include('front.speaking.partials.talk')
    @endforeach
</x-app-layout>
