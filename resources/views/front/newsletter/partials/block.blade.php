<div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-yellow-50 border-b-5 border-yellow-200 text-sm text-gray-700 {{ $class ?? '' }} markup">
    <p class="font-extrabold text-2xl leading-tight mb-2 text-black">
        Join 9,000+ developers
    </p>
    <p class="mb-4 text-base text-gray-600 leading-relaxed">
        Every month, I share practical tips, tutorials, and behind-the-scenes insights from maintaining 300+ open source packages.
    </p>
    @include('front.newsletter.partials.form', ['class' => 'mb-4'])
    <p class="text-xs text-gray-500">
        No spam. Unsubscribe anytime.
        You can also follow me on <a href="https://x.com/freekmurze">X</a>.
    </p>
</div>
