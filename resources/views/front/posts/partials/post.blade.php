<article class="{{ $class ?? '' }}">
    <div class="post-theme mb-4" style="--theme: {{ $post->theme }}"></div>
    <header class="mb-6">
        <h1 class="max-w-lg text-3xl font-black leading-tight mb-2">
            @isset($url)
                <a href="{{ $url }}">{{ $post->title }}</a>
            @else
                {{ $post->title }}
            @endisset
        </h1>
        <p class="text-sm text-gray-600">
            {{ $post->emoji }}
            <a href="{{ $post->url }}">
                <time datetime="{{ optional($post->publish_date)->format(DateTime::ATOM) }}">
                    {{ $post->publish_date }}</time></a>
            @if($post->type === 'originalPost')
                𐄁 by {{ $post->author }}
                𐄁 {{ $post->reading_time }} minute read
            @elseif($post->external_url)
                𐄁
                <a href="{{ $post->external_url }}">
                    {{ $post->external_url_host }}
                </a>

            @endif
            @auth
                𐄁
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
