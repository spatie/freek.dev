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
    </div>

    @if($latestCampaign)
        <div class="mb-8">
            <h2 class="font-extrabold text-xl text-black mb-4">Here's the latest edition</h2>
            @include('front.newsletter.partials.email-card', ['campaign' => $latestCampaign])
        </div>
    @endif

    <div class="markup">
        <p>
            Browse all previous editions in <a href="{{ route('newsletter.archive.index') }}">the newsletter archive</a>. Every edition contains one or two sponsored links. Here's <a href="/advertising">some more info</a> on that.
        </p>
    </div>
</x-app-layout>
