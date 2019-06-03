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

        <p class="mt-6 no-markup">
            @if($post->external_url)
                <a href="{{ $post->external_url }}" class="font-semibold text-gray-600 pb-1 border-b-2">
                    Read more on {{ $post->external_url_host }}
                </a>
            @else
                <a href="{{ $post->url }}" class="font-semibold text-gray-600 pb-1 border-b-2">
                    Read more
                </a>
            @endif
        </p>
    @endcomponent
@endforeach
