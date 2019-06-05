@extends('front.layouts.app', [
    'title' => 'Newsletter',
])

@section('content')
    <div class="markup mb-8">
        <h1>Newsletter</h1>
        <p>
            Every two weeks I send out a newsletter containing lots of interesting stuff for the modern PHP developer.
        </p>
        <p>
            Expect quick tips, links to interesting tutorials, opinions and packages. Because I work with Laravel every
            day there is an emphasis on that framework.
        </p>
        <p>
            Want to know what you're getting yourself into? Here's <a href="https://sendy.freek.dev/w/db6bg1gpZgjCkCxhjltj4g">a previous edition</a>.
        </p>
    </div>
    <div class="mb-8 -mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-orange-100 border-b-5 border-orange-200 text-sm text-gray-700">
        @include('front.newsletter.partials.form')
    </div>
    <div class="markup">
        <p>
            Every edition of the newsletter contains one or two sponsored links. Here’s <a href="/advertising">some more
            info</a> on that.
        </p>
    </div>
@endsection
