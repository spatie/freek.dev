<x-app-layout title="Newsletter">

    <div class="markup mb-8">
        <h1>Newsletter</h1>
        <p>
            Every month I share what I learn from running Spatie, building Oh Dear, and maintaining over 300 open source packages. That means practical tips on Laravel, PHP, and AI that come from shipping real products every day.
        </p>
        <p>
            Expect honest takes, useful tutorials, and the occasional behind-the-scenes look at how we build and maintain things at Spatie. Over 9,500 smart developers already get it in their inbox.
        </p>
    </div>

    <div class="mb-8 -mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-yellow-50 border-b-5 border-yellow-500 text-sm text-gray-700">
        @include('front.newsletter.partials.form')
        <p class="mt-3 text-xs text-gray-400">
            Your email will only be used for this newsletter. No spam, no sharing. Unsubscribe at any time.
        </p>
    </div>

    @if($latestCampaign)
        <div class="markup mb-4">
            <h2>Here's the latest edition</h2>
            <p>
                Not sure what to expect? Here's a preview of the most recent newsletter.
            </p>
        </div>
        <div class="mb-8">
            @include('front.newsletter.partials.email-card', ['campaign' => $latestCampaign])
        </div>
    @endif

    <div class="markup mb-8">
        <h2>Archive</h2>
        <p>
            Missed an edition? No worries. Every newsletter is kept in <a href="{{ route('newsletter.archive.index') }}">the archive</a>, so you can always go back and find that tip or link you vaguely remember reading about.
        </p>
    </div>

    <div class="markup">
        <h2>Sponsorship</h2>
        <p>
            Every edition includes one or two sponsored links from tools and services relevant to PHP and Laravel developers. It's a way to keep the newsletter free while only showing things that are actually useful to you.
        </p>
        <p>
            If you'd like to reach over 9,500 developers who build with Laravel and PHP every day, take a look at <a href="/advertising">the advertising page</a>.
        </p>
    </div>
</x-app-layout>
