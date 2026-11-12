@include('front.layouts.partials.head')

<div class="max-w-5xl mx-auto min-h-screen flex items-center pb-16">
    <div class="md:flex items-end">
        <div class="mb-4 md:mb-0">
            <img src="{{ url('images/404.webp') }}" width="673" height="371" alt="‘Computer says no’ woman from Little Britain">
        </div>
        <div class="font-sans text-black leading-none text-center md:text-left">
            <h1 class="text-5xl font-extrabold mb-2">{{ $errorCode }}</h1>
            <p class="text-xl text-gray-700">
                Computer says no.
                @if($homeLink ?? false)
                    <a href="{{ url('/') }}" class="link">Go home</a>
                @endif
            </p>
            @if($homeLink ?? false)
                <p class="mt-4 text-base text-gray-600 leading-normal">
                    Looking for a specific post? <a href="{{ route('search') }}" class="link">Search the blog</a> or <a href="{{ route('archive') }}" class="link">browse the archive</a>.
                </p>
            @endif
        </div>
    </div>
</div>
