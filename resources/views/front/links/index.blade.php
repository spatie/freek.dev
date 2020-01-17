@extends('front.layouts.app', [
    'title' => 'Links',
])

@section('content')
    <div
        class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-grey-200 text-sm text-gray-700">
        <p class="mb-4">
            Did you write or stumbled across a blog post, tutorial or video that might be interesting my audience?
        </p>
        @auth
            <div class="flex items-center">
                <a href="{{ route('links.create') }}" class="mr-4 button button-gray">Submit a link</a>

                <form method="post" action="/logout">
                    @csrf
                    <button class="text-xs text-gray-70" type="submit">log out</button>
                </form>
            </div>
        @endauth
        @guest
            <p class="mb-4">
                To be able to submit a link you need to log in first.
            </p>

            <a href="{{ route('links.create') }}" class="button button-gray">Log in</a>
        @endguest
    </div>

    <div class="mt-8">
        @forelse($links as $link)
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
        @empty
            You haven't submitted any links yet
        @endforelse

        {{ $links->links() }}
    </div>

@endsection
