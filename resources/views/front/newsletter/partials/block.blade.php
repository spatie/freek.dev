<div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-yellow-50 border-b-5 border-yellow-200 text-sm text-gray-700 {{ $class ?? '' }} markup">
    <p class="font-extrabold text-2xl leading-tight mb-2 text-black">
        Join 9,500+ smart developers
    </p>
    <p class="mb-4 text-base text-gray-600 leading-relaxed">
        Every month I share what I learn from running Spatie, building Oh Dear, and maintaining 300+ open source packages. Practical takes on Laravel, PHP, and AI that you can actually use.
    </p>
    @include('front.newsletter.partials.form', ['class' => 'mb-4'])
    @include('front.newsletter.partials.testimonial')
    <p class="text-xs text-gray-500">
        No spam. Unsubscribe anytime.
        You can also <a href="https://x.com/freekmurze" class="text-gray-600 underline decoration-gray-300 hover:text-black hover:decoration-black transition-colors">follow me on X</a>.
    </p>
</div>
