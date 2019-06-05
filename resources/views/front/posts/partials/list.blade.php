@foreach($posts as $post)
    @if($loop->index === 2)
        <div class="mb-12 md:mb-24 md:-mt-4">
            @include('front.newsletter.partials.block')
        </div>
    @endif

    @component('front.posts.partials.post', [
        'post' => $post,
        'url' => $post->external_url ?: $post->url,
        'class' => 'mb-12 md:mb-24',
        'heading' => 'h2',
    ])
        {!! $post->excerpt !!}

        @unless($post->isTweet())
            <p class="mt-6">
                @if($post->external_url)
                    <a href="{{ $post->external_url }}">
                        Read more</a>
                    <span class="text-xs text-gray-700">[{{ $post->external_url_host }}]</span>
                @else
                    <a href="{{ $post->url }}">
                        Read more
                    </a>
                @endif
            </p>
        @endunless
    @endcomponent
@endforeach
