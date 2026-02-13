@foreach($posts as $post)
    @if($loop->index === 2)
        <div class="mb-12 md:mb-24 md:-mt-4">
            @include('front.newsletter.partials.block')
        </div>
    @endif

    <div class="{{ $post->isOriginal() ? '' : 'opacity-80' }}">
        <x-post-header
            :post="$post"
            class="mb-12 md:mb-24'"
            :url="$post->external_url ?: $post->url"
            heading="h2"
        >

            {!! $post->excerpt !!}

            @unless($post->isTweet())
                <p class="mt-6">
                    @if($post->external_url)
                        <a href="{{ $post->external_url }}" target="_blank" rel="noopener noreferrer">
                            Read more</a>
                        <span class="text-xs text-gray-700">[{{ $post->external_url_host }}]</span>
                    @else
                        <a wire:navigate.hover href="{{ $post->url }}">
                            Read more
                        </a>
                    @endif
                </p>
            @endunless
        </x-post-header>
    </div>
@endforeach
