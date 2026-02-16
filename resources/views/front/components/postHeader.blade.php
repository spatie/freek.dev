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
                @unless(\Illuminate\Support\Str::startsWith($url, ['/', url('/')]))
                    target="_blank" rel="noopener noreferrer"
                @endunless
            >{{ $post->title }}
            </a>
        @else
            {{ $post->title }}
        @endisset
        @if($post->isOriginal())
            <span class="text-[10px] font-medium text-gray-400 border border-gray-200 rounded-full px-1.5 py-0.5 align-middle ml-1">original</span>
        @endif
    </{{ $heading ?? 'h1' }}>

    <p class="text-sm text-gray-700">
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
    @if(($showTags ?? false) && $post->tags->isNotEmpty())
        <div class="flex flex-wrap gap-1.5 mt-2 max-w-lg">
            @foreach($post->tags->sortBy->name as $tag)
                <a
                    href="{{ route('taggedPosts.index', $tag->slug) }}"
                    class="bg-gray-50 rounded-md px-2.5 py-1 text-[13px] text-gray-500 hover:bg-gray-100 hover:text-black transition-colors"
                >
                    {{ $tag->name }}
                </a>
            @endforeach
        </div>
    @endif
    </header>
    <div class="markup leading-relaxed">
        {{ $slot }}
    </div>
</article>
