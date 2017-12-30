@extends('front.layouts.master')

@section('title', 'Newsletter')

@section('content')

    <h1 class="pb-4 border-b">Newsletter</h1>
    <p class="pt-6">
        Every two weeks I send out a newsletter containing lots of interesting stuff for the modern PHP developer. You
        can expect quick tips, links to interesting tutorials, opinions and packages. Because I work with Laravel every
        day there is an emphasis on that framework.
   </p>

    <p>
        Want to know what you're getting yourself into? Here's <a href="https://sendy.murze.be/w/db6bg1gpZgjCkCxhjltj4g">a previous
            edition</a>.
    </p>

    <form class="pt-4 pb-4 flex justify-center" action="https://sendy.murze.be/subscribe" method="post"
          accept-charset="utf-8">
        <div class="flex flex-1 max-w-sm">
            <input type="email" id="email" name="email"
                   class="w-2/3 rounded-l border p-3"
                   placeholder="Your email…" required="required">
            <input type="submit" name="submit" id="submit" value="Subscribe"
                   class="w-1/3 rounded-r bg-blue text-white py-2 px-2 text-base font-bold clickable border-none">
            <input type="hidden" name="list" value="SGDpioFb8i8923zG5xWPFw5A">
        </div>
    </form>

    <p>
        Rest assured that I will only use your email address to send you the newsletter and will
        not use it for any other purposes.
    </p>

    <p>
        Every edition of the newsletter contains one or two sponsored links. Here’s <a href="/advertising">some more
            info</a> on that.

    </p>
@endsection
