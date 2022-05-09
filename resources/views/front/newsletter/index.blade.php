<x-app-layout title="Newsletter">

    <div class="markup mb-8">
        <h1>Newsletter</h1>
        <p>
            Every month I send out a newsletter containing lots of interesting stuff for the modern PHP developer.
        </p>
        <p>
            Expect quick tips, links to interesting tutorials, opinions and packages. Because I work with Laravel every
            day there is an emphasis on that framework.
        </p>
        <p>
            Want to know what you're getting yourself into? Take a look at <a href="#archive">the newsletter archive</a>.
        </p>
    </div>
    <div class="mb-8 -mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-yellow-50 border-b-5 border-yellow-500 text-sm text-gray-700">
        @include('front.newsletter.partials.form')
    </div>
    <div class="markup">
        <p>
            Every edition of the newsletter contains one or two sponsored links. Here’s <a href="/advertising">some more
                info</a> on that.
        </p>
    </div>

    <div class="markup">
        <h2 id="archive">Archive <a href="#archive" class="permalink">#</a></h2>
        <p>
            Here are the links to the newsletters I've previously sent.
        </p>
        @foreach($pastCampaigns as $campaign)
            <div>
                <a href="{{ route('newsletter.show', $campaign->id) }}">{{ $campaign->subject }}</a>
                <div class="text-gray-700 text-xs">sent on {{ $campaign->sent_at->format('jS F Y') }}</div>
            </div>
        @endforeach
    </div>
</x-app-layout>
