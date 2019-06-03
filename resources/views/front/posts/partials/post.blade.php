<article class="{{ $class ?? '' }}">
    <div class="post-theme mb-4" style="--theme: {{ $post->theme }}"></div>
    <header class="mb-6">
        <{{ $heading ?? 'h1' }} class="max-w-lg text-2xl md:text-3xl font-extrabold leading-tight mb-2">
            @isset($url)
                <a href="{{ $url }}">{{ $post->title }}</a>
            @else
                {{ $post->title }}
            @endisset
        </{{ $heading ?? 'h1' }}>
        <p class="text-sm text-gray-600">
            {{ $post->emoji }} {{ $post->publish_verb }}
            <a href="{{ $post->url }}">
                <time datetime="{{ optional($post->publish_date)->format(DateTime::ATOM) }}">
                    {{ $post->publish_date->format('M jS Y') }}
                </time>
            </a>
            @if($post->external_url)
                –
                <a href="{{ $post->external_url }}">
                    {{ $post->external_url_host }}
                </a>
            @elseif($post->isOriginal())
                – by {{ $post->author }}
                – {{ $post->reading_time }} minute read
            @endif
            @auth
                –
                <a target="_blank" href="/nova/resources/posts/{{ $post->id }}/edit" class="underline">
                    Edit
                </a>
            @endauth
        </p>
    </header>
    <div class="markup leading-relaxed">
        {{ $slot }}
    </div>
</article>
