@extends('front.layouts.master')

@section('title', 'About me')

@section('content')

    <h1 class="pb-4 border-b">About me</h1>

    @include('front.me._partials.freek')

    <p>
        I live in Antwerp, Belgium and am passionate about PHP. I'm a Laravel enthusiast and have used
        the framework for many projects.  Follow me <a href="http://twitter.com/freekmurze">on twitter</a> to know what
        keeps me busy.
    </p>

    <p>
        Together with my buddies <a href="https://twitter.com/driesvints">Dries</a> and <a
                href="https://twitter.com/maybefrederick">Frederick</a> I organise our local PHP user group <a
                href="http://phpantwerp.be">PHP Antwerp</a>. If you're ever in the area of our beautiful city and want
        to speak at our user group, let us know!
    </p>

    <p>
        At Spatie we use a lot of open source software: PHP, Ubuntu, Laravel, Composer, Beanstalkd,… are a few of the
        things we use everyday. My company couldn't exists without open source software. That's why we're trying to give back
        as much as possible.
    </p>

    <p>
        Whenever we stumble upon a problem that we can solve in a clean way, we extract our solution so other developers can use it.
        Together with my colleagues I regularly release <a href="https://spatie.be/opensource">PHP, Laravel and
            JavaScript packages</a>. Those packages have been downloaded a couple of million times. Spatie is 
        ranked as number 4 on <a href="http://git-awards.com/users?language=php">Git Awards' list of PHP developers
            worldwide</a>.
    </p>

    <p>
        I love public speaking and try to do it a lot. Here's a list of past user group meetups and conferences where I had the pleasure of speaking.
    </p>

    @include('front.me._partials.talks')
@endsection

