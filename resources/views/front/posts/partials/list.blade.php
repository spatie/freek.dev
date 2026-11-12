@foreach($posts as $post)
    @if($loop->index === 2)
        <div class="mb-12 md:mb-24 md:-mt-4">
            @include('front.newsletter.partials.block')
        </div>
    @endif

    <div class="{{ $post->isOriginal() || $post->shared_tweet_url ? '' : 'opacity-80' }}">
        <x-post-header
            :post="$post"
            class="mb-12 md:mb-24"
            :url="$post->shared_tweet_url ? $post->url : ($post->external_url_with_utm ?: $post->url)"
            heading="h2"
        >

            {!! $post->excerpt !!}

            @if($post->shared_tweet_url)
                @include('front.posts.partials.tweet')
            @endif

            @unless($post->isTweet())
                <p class="mt-6">
                    @if($post->external_url)
                        <a href="{{ $post->external_url_with_utm }}" target="_blank" rel="noopener noreferrer">
                            Read more</a>
                        <span class="text-xs text-gray-700">[{{ $post->external_url_host }}]</span>
                    @else
                        <a href="{{ $post->url }}">
                            Read more
                        </a>
                    @endif
                </p>
            @endunless
        </x-post-header>
    </div>
@endforeach
