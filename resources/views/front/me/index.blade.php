@extends('front.layouts.master')

@section('title', 'About me')

@section('content')

    <h1 class="pb-4 border-b">About me</h1>

    @include('front.me._partials.freek')

    <p>
        I live in Ghent, Belgium and am passionate about PHP. I'm a Laravel enthusiast and have used
        the framework for many projects.  Follow me <a href="http://twitter.com/freekmurze">on twitter</a> to know what
        keeps me busy.
    </p>

    <p>
        I'm a developer at <a href="https://spatie.be">Spatie</a> of which I'm the co-owner. At my company we use a lot of open source software: PHP, Ubuntu, Laravel, Composer, Beanstalkd,… are a few of the
        things we use everyday. My company couldn't exist without open source software. That's why we're trying to give back
        as much as possible.
    </p>

    <p>
        Whenever we stumble upon a problem that we can solve in a clean way, we extract our solution so other developers can use it.
        Together with my colleagues I regularly release <a href="https://spatie.be/opensource">PHP, Laravel and
            JavaScript packages</a>. Those packages have been downloaded more than 15 million times.
    </p>

    <h2 id="side-projects">
        Side projects
        <a class="text-grey" href="#side-projects">#</a>
    </h2>

    <p>
        Outside of Spatie, my friend <a href="https://twitter.com/mattiasgeniar">Mattias</a> and I are running a Saas named <a href="https://ohdear.app">Oh Dear!</a> Our service can notify you via Mail, Slack,... when your site is down, when it contains broken links, when it finds mixed content, ... It aims to be very easy to use, we have great developer docs and APIs. <a href="https://ohdear.app/register">Try it out!</a>
    </p>

    <p>
        Together with my buddies <a href="https://twitter.com/driesvints">Dries</a> and <a
                href="https://twitter.com/riasvdv">Rias</a> I organise the <a
                href="http://fullstackantwerp.be">Full Stack Antwerp</a> usergroup. If you're ever in the area of our beautiful city and want to speak at our user group, let us know!
    </p>

    <p>Together with the aforementioned Dries, I'm also organising the Full Stack Europe conference in the city of Antwerp. Full Stack Europe will be a conference for every kind of developer. We will offer talks for developers who want to learn across a wide variety of skills. We plan on holding it somewhere in 2019. For more info read <a href="https://blog.usejournal.com/announcing-full-stack-europe-f49422f14308">Dries' announcement blogpost</a> All you need to do to stay in the loop is to subscribe yourself <a href="https://fullstackeurope.com/">on our mailinglist</a>.</p>

    <p>
        I also love public speaking and try to do it a lot. Here's a list of past user group meetups and conferences where I had the pleasure of speaking.
    </p>

    @include('front.me._partials.talks')
@endsection
