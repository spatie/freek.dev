@foreach($posts as $post)
    @if($loop->index === 2)
        <div class="mb-24 -mt-4">
            @include('front.newsletter.partials.form')
        </div>
    @endif
    @component('front.posts.partials.post', [
        'post' => $post,
        'url' => $post->external_url ?: $post->url,
    ])
        {!! $post->excerpt !!}

        <p class="mt-6 no-markup">
            @if($post->is_original)
                <a href="{{ $post->url }}" class="font-semibold text-gray-600 pb-1 border-b-2">
                    Read more
                </a>
            @elseif($post->external_url)
                <a href="{{ $post->external_url }}" class="font-semibold text-gray-600 pb-1 border-b-2">
                    Read more on {{ $post->external_url_host }}
                </a>
            @endif
        </p>
    @endcomponent
@endforeach
