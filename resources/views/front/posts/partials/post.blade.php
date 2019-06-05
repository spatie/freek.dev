<article class="{{ $class ?? '' }}">
    @auth
        <a href="/nova/resources/posts/{{ $post->id }}/edit">Edit</a>
    @endauth
    <div class="mb-5" style="
        height: 6px;
        background-color: {{ $post->theme }};
        box-shadow: 0 3px 0 {{ $post->theme }}dd, 0 3px 0 #000;
    "></div>
    <header class="mb-6">
        <{{ $heading ?? 'h1' }} class="max-w-lg text-2xl md:text-3xl font-extrabold leading-tight mb-1">
            @isset($url)
                <a href="{{ $url }}">{{ $post->title }}</a>
            @else
                {{ $post->title }}
            @endisset
        </{{ $heading ?? 'h1' }}>
        <p class="text-sm text-gray-700">
            {{ $post->formatted_type }} –
            <a href="{{ $post->url }}">
                <time datetime="{{ optional($post->publish_date)->format(DateTime::ATOM) }}">
                    {{ $post->publish_date->format('M jS Y') }}
                </time>
            </a>
            @if($post->external_url)
                –
                <a href="{{ $post->external_url }}">
                    {{ $post->external_url_host }}</a>
            @elseif($post->isOriginal())
                by {{ $post->author }}
                – {{ $post->reading_time }} minute read
            @endif
            @auth
                –
                <a target="_blank" href="/nova/resources/posts/{{ $post->id }}/edit">
                    Edit</a>
            @endauth
        </p>
    </header>
    <div class="markup leading-relaxed">
        {{ $slot }}
    </div>
</article>
