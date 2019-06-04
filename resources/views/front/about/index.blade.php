@extends('front.layouts.app', [
    'title' => 'About',
])

@section('content')
    <div class="markup mb-6">
        <h1>About</h1>
    </div>
    <img
        src="{{ url('images/avatar-boxed.jpg') }}"
        alt="Freek Van der Herten speaking at Laracon EU 2019"
        class="sm:w-48 sm:ml-3 mb-6 sm:mb-0 sm:rounded-full sm:float-right"
    >
    <div class="markup">
        <p>
            I live in Ghent, Belgium and am passionate about PHP. I'm a Laravel enthusiast and have used the framework for many projects.  Follow me <a href="http://twitter.com/freekmurze">on Twitter</a> to know what keeps me busy. Want to know which IDE, apps and hardware I use? <a href="/my-current-setup-2018-edition">Here you go</a>!
        </p>
        <p>
            I'm a developer at <a href="https://spatie.be">Spatie</a> of which I'm the co-owner. At my company we use a lot of open source software: PHP, Ubuntu, Laravel, Composer, Yarn,… are a few of the things we use everyday. My company couldn't exist without open source software. That's why we're trying to give back as much as possible.
        </p>
        <p>
            Whenever we stumble upon a problem that we can solve in a clean way, we extract our solution so other developers can use it. Together with my colleagues I regularly release <a href="https://spatie.be/opensource">PHP, Laravel and JavaScript packages</a>. Those packages have been downloaded more than 35 million times.
        </p>
        <h2 id="side-projects">
            Side projects
        </h2>
        <p>
            Outside of Spatie, my friend <a href="https://twitter.com/mattiasgeniar">Mattias</a> and I are running a Saas named <a href="https://ohdear.app">Oh Dear!</a> Our service can notify you via Mail, Slack,... when your site is down, when it contains broken links, when it finds mixed content, ... It aims to be very easy to use, we have great developer docs and APIs. <a href="https://ohdear.app/register">Try it out!</a>
        </p>
        <p>
            Together with my buddy <a href="https://twitter.com/driesvints">Dries</a>  I organise the <a href="https://fullstackeurope.com">Full Stack Europe</a> conference. We'll offer talks for developers who want to learn across a wide variety of skills. For more info head over to <a href="https://fullstackeurope.com">our website</a>.
        </p>
    </div>
@endsection
