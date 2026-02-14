<x-app-layout title="Newsletter">

    <div class="markup mb-8">
        <h1>Newsletter</h1>
        <p>
            Every month I share what I learn from running Spatie, building Oh Dear, and maintaining over 300 open source packages. That means practical tips on Laravel, PHP, and AI that come from shipping real products every day.
        </p>
        <p>
            Expect honest takes, useful tutorials, and the occasional behind-the-scenes look at how we build and maintain things at Spatie. Over 9,500 smart developers already get it in their inbox.
        </p>
        <p>
            Want to know what you're getting yourself into? Take a look at <a href="https://freek-dev.mailcoach.app/archive">the newsletter archive</a>.
        </p>
    </div>
    <div class="mb-8 -mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-yellow-50 border-b-5 border-yellow-500 text-sm text-gray-700">
        @include('front.newsletter.partials.form')
    </div>
    <div class="markup">
        <p>
            Every edition of the newsletter contains one or two sponsored links. Here's <a href="/advertising">some more
                info</a> on that.
        </p>
    </div>
</x-app-layout>
