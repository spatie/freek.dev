@extends('front.layouts.master')

@section('title', 'Newsletter')

@section('content')
    <div class="markup mb-8">
        <h1>Newsletter</h1>
        <p>
            Every two weeks I send out a newsletter containing lots of interesting stuff for the modern PHP developer. You
            can expect quick tips, links to interesting tutorials, opinions and packages. Because I work with Laravel every
            day there is an emphasis on that framework.
        </p>
        <p>
            Want to know what you're getting yourself into? Here's <a href="https://sendy.murze.be/w/db6bg1gpZgjCkCxhjltj4g">a previous edition</a>.
        </p>
    </div>
    <div class="mb-8">
        @include('front.newsletter.partials.form')
    </div>
    <div class="markup">
        <p>
            Every edition of the newsletter contains one or two sponsored links. Here’s <a href="/advertising">some more
            info</a> on that.
        </p>
    </div>
@endsection
