@extends('front.layouts.master')

@section('title', 'About me')

@section('content')

    <h1 class="pb-4 border-b">About</h1>

    @include('front.about._partials.freek')

    <p>
    Together with my colleagues I regularly release <a href="https://spatie.be/opensource">PHP, Laravel and JavaScript packages</a>. Those packages have been downloaded over <a href="https://murze.be/2016/09/one-million-downloads/"><del datetime="2017-09-23T11:47:26+00:00">two million times</del></a> five million times.  Follow me <a href="http://twitter.com/freekmurze">on twitter</a> to know what I'm working on.
    </p>

    <p>
    I also am a co-organizer of my local PHP User Group: <a href="http://phpantwerp.be">PHP Antwerp</a>.
    </p>

    <p>
    I love public speaking and try do it a lot. Here's a video of my conference talk at Laracon EU 2016:
    </p>
    <iframe width="853" height="480" src="https://www.youtube.com/embed/fORNQ06K8LY?rel=0" frameborder="0" allowfullscreen></iframe>

    <p>
    This is the talk I gave at Laracon EU 2017:
    </p>

    <iframe width="853" height="480" src="https://www.youtube.com/embed/jtB_rTh61Zo" frameborder="0" allowfullscreen></iframe>
@endsection

