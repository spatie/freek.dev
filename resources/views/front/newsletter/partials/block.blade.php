<div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-orange-100 border-b-5 border-orange-200 text-sm text-gray-700 {{ $class ?? '' }}">
    <p class="font-extrabold text-2xl leading-tight mb-4 text-black">
        Stay up to date with all things Laravel, PHP, and JavaScript.
    </p>
    <p class="mb-2">
        Every two weeks I send out a newsletter containing lots of interesting stuff for the modern PHP developer.
    </p>
    <p class="mb-3">
        Expect quick tips & tricks, interesting tutorials, opinions and packages. Because I work with Laravel every day there is an emphasis on that framework.
    </p>
    @include('front.newsletter.partials.form', ['class' => 'mb-3'])
    <p>
        Rest assured that I will only use your email address to send you the newsletter and will not use it for any other purposes.
    </p>
</div>
