@extends('front.layouts.master')

@section('title', 'Newsletter')

@section('content')

    <h1 class="pb-4 border-b">Newsletter</h1>
    <p class="pt-6">
        Every two weeks I send out a newsletter containing lots of interesting stuff for the modern PHP developer. You
        can expect quick tips, links to interesting tutorials, opinions and packages. Because I work with Laravel every
        day there is an emphasis on that framework. I’ll only use your email address to send you the newsletter and will
        not use it for any other purposes.
    </p>
        <form class="pt-4 pb-4" action="https://sendy.murze.be/subscribe" method="post" accept-charset="utf-8">
            <div class="flex">
                <input type="email" id="email" class="p-2 w-64"
                       placeholder="Your Email..." required="required">
                <input type="submit" name="submit" id="submit" value="Sign me up!"
                       class="bg-blue text-white py-2 px-4 text-xs font-bold clickable border-none rounded-none">
            </div>
        </form>
    <p>
        Every edition of the newsletter contains one or two sponsored links. Here’s <a href="/advertising">some more info</a> on that.

    </p>
@endsection