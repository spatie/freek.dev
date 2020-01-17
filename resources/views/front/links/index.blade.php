@extends('front.layouts.app', [
    'title' => 'Links',
])

@section('content')
    <div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-orange-100 border-b-5 border-orange-200 text-sm text-gray-700 {{ $class ?? '' }} markup">
        <p class="mb-2">
            Did you write or stumbled across a blog post, tutorial or video that might be interesting my audience?
        </p>
        <a href="{{ route('links.create') }}" class="button button-orange">Submit a link</a>
    </div>

    <div class="mt-8">
    @foreach($links as $link)
        <article class="mb-12 md:mb-24">
            <div class="mb-5" style="
        height: 6px;
        background-color: #cbd5e0;
        box-shadow: 0 3px 0 #cbd5e0dd, 0 3px 0 #000;
        "></div>
            <header class="mb-6">
                <h2 class="max-w-lg text-2xl md:text-3xl font-extrabold leading-tight mb-1">
                    <a href="{{ $link->url }}">{{ $link->title }}</a>
                </h2>

                <p class="text-sm text-gray-700">
                    <a href="{{ $link->url }}">
                        <time datetime="{{ optional($link->created_at)->format(DateTime::ATOM) }}">
                            {{ $link->created_at->format('M jS Y') }}
                        </time>
                    </a>
                    –
                    <a href="{{ $link->url }}">
                        {{ $link->host_url }}</a>
                    -
                    submitted by {{ $link->user->name }}
                </p>
            </header>
            <div class="markup leading-relaxed">
                <p>{{ $link->text }}</p>
            </div>
        </article>
    @endforeach

    {{ $links->links() }}
    </div>

@endsection
