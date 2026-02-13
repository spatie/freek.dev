<article class="{{ $class ?? '' }}">
    <div class="mb-5" style="
        height: 6px;
        background-color: {{ $post->theme }};
        box-shadow: 0 3px 0 {{ $post->theme }}dd, 0 3px 0 #000;
        "></div>
    <header class="mb-6">
        <{{ $heading ?? 'h1' }} class
        ="max-w-lg text-2xl md:text-3xl font-extrabold leading-tight mb-1">
        @isset($url)
            <a
                href="{{ $url }}"
                @if(\Illuminate\Support\Str::startsWith($url, ['/', url('/')]))
                    wire:navigate.hover
                @else
                    target="_blank" rel="noopener noreferrer"
                @endif
            >{{ $post->title }}
            </a>
        @else
            {{ $post->title }}
        @endisset
    </{{ $heading ?? 'h1' }}>

    <p class="text-sm text-gray-700">
        {{ $post->formatted_type }} –
        <a href="{{ $post->url }}">
            @if ($post->publish_date)
                <time datetime="{{ $post->publish_date?->format(DateTime::ATOM) }}">
                    {{ $post->publish_date?->format('M jS Y') }}
                </time>

            @else
                This post has not been published yet
            @endif
        </a>
        @if($post->external_url)
            –
            <a href="{{ $post->external_url }}" target="_blank" rel="noopener noreferrer">
                {{ $post->external_url_host }}</a>
        @elseif($post->isOriginal())
            by {{ $post->author }}
            – {{ $post->reading_time }} minute read
        @endif
        @if ($post->submittedByUser)
            - submitted by
            @if ($post->submittedByUser->twitter_handle)
                <a target="_blank" rel="noopener noreferrer"
                   title="https://twitter.com/{{ $post->submittedByUser->twitter_handle }}"
                   href="https://twitter.com/{{ $post->submittedByUser->twitter_handle }}">
                    {{ $post->submittedByUser->name }}
                </a>
            @else
                {{ $post->submittedByUser->name }}
            @endif
        @endif
        @auth
            @if(Auth::user()->admin)
                –
                <a target="_blank" href="/admin/posts/{{ $post->id }}/edit">
                    Edit</a>
            @endif
        @endauth
    </p>
    </header>
    <div class="markup leading-relaxed">
        {{ $slot }}
    </div>
</article>
