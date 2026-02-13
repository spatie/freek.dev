<x-app-layout :title="$post->title" :canonical="$post->external_url">
    <x-post-header :post="$post" class="mb-8" :showTags="true">

        {!! $post->html !!}

        @unless($post->isTweet())
            @if($post->external_url)
                <p class="mt-6">
                    <a href="{{ $post->external_url }}" target="_blank" rel="noopener noreferrer">
                        Read more</a>
                    <span class="text-xs text-gray-700">[{{ $post->external_url_host }}]</span>
                </p>
            @endif
        @endunless
    </x-post-header>

    @include('front.posts.partials.post-navigation')

    <div class="mb-8">
        @include('front.posts.partials.share')
    </div>

    @include('front.newsletter.partials.block', [
        'class' => 'mb-8',
    ])

    @include('front.posts.partials.keep-reading')

    <p class="text-sm text-gray-600 mb-8">
        Found something interesting to share? <a href="{{ route('community.link.create') }}" class="underline hover:text-black">Submit a link</a> to the <a href="{{ route('community.index') }}" class="underline hover:text-black">community section</a>.
    </p>

    <x-slot name="seo">
        <meta property="og:title" content="{{ $post->title }} | freek.dev"/>
        <meta property="og:description" content="{{ $post->plain_text_excerpt }}"/>
        <meta name="og:image" content="{{ url($post->getFirstMediaUrl('ogImage')) }}"/>

        @foreach($post->tags as $tag)
            <meta property="article:tag" content="{{ $tag->name }}"/>
        @endforeach

        <meta property="article:published_time" content="{{ $post->publish_date?->toIso8601String() }}"/>
        <meta property="og:updated_time" content="{{ $post->updated_at->toIso8601String() }}"/>
        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:description" content="{{ $post->plain_text_excerpt }}"/>
        <meta name="twitter:title" content="{{ $post->title }} | freek.dev"/>
        <meta name="twitter:site" content="@freekmurze"/>
        <meta name="twitter:image" content=""/>
        <meta name="twitter:creator" content="@freekmurze"/>
    </x-slot>
</x-app-layout>
