<x-app-layout title="Newsletter">

    <div class="markup mb-8">
        <h1>Newsletter</h1>
        <p>
            Every month I send a newsletter to 9,000+ PHP and Laravel developers. It contains practical tips, interesting tutorials, opinions and packages I've been working on.
        </p>
        <p>
            Because I work with Laravel every day and maintain over 300 open source packages, there's an emphasis on real-world Laravel development.
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
