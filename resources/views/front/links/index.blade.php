<x-app-layout title="Links">
    <div
        class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700">

        <p class="mb-4">
            In this section you'll find links submitted by others.
        </p>

        <p class="mb-4">
            Did you write or stumbled across a blog post, tutorial or video that might be interesting for others?
        </p>
        @auth
            <p class="mb-2">
                Logged in as
                @if(Auth::user()->twitter_handle)
                    <a target="_blank" rel="noopener noreferrer"
                       title="https://twitter.com/{{ Auth::user()->twitter_handle }}"
                       href="https://twitter.com/{{ Auth::user()->twitter_handle }}">
                        {{ Auth::user()->name }}
                    </a>
                @else
                    {{ Auth::user()->name }}
                @endif
                ({{ Auth::user()->email }})
            </p>
            <div class="flex items-center">
                <a href="{{ route('community.link.create') }}" class="mr-4 button button-gray">Submit a link</a>

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

            <a href="{{ route('community.link.create') }}" class="button button-gray">Log in</a>
        @endguest
    </div>

    <div class="mt-8">
        @foreach($links as $link)
            <article class="mb-12 md:mb-12">
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
                        submitted by
                        @if ($link->user->twitter_handle)
                            <a target="_blank" rel="noopener noreferrer"
                               title="https://twitter.com/{{ $link->user->twitter_handle }}"
                               href="https://twitter.com/{{ $link->user->twitter_handle }}">
                                {{ $link->user->name }}
                            </a>
                        @else
                            {{ $link->user->name }}
                        @endif
                    </p>
                </header>
                <div class="markup leading-relaxed">
                    <p>{{ $link->text }}</p>
                </div>
                <div class="markup">
                    <p class="mt-6">
                        <a href="{{ $link->url }}">Read more</a>
                        <span class="text-xs text-gray-700">[{{ $link->host_url }}]</span>
                    </p>
                </div>
            </article>
        @endforeach

        {{ $links->links() }}
    </div>
</x-app-layout>
