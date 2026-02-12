<x-app-layout :title="$post->title" :canonical="$post->external_url">
    <x-ad/>

    <x-post-header :post="$post" class="mb-8">

        {!! $post->html !!}

        @unless($post->isTweet())
            @if($post->external_url)
                <p class="mt-6">
                    <a href="{{ $post->external_url }}">
                        Read more</a>
                    <span class="text-xs text-gray-700">[{{ $post->external_url_host }}]</span>
                </p>
            @endif
        @endunless
    </x-post-header>

    <div class="mb-8">
        @include('front.posts.partials.share')
    </div>

    @include('front.newsletter.partials.block', [
        'class' => 'mb-8',
    ])

    <div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700 mb-8 markup">
        <p class="font-extrabold text-lg leading-tight mb-2 text-black">
            Found something interesting to share?
        </p>
        <p>
            The <a href="{{ route('community.index') }}">community section</a> is a place where developers share links to articles, tutorials and videos. <a href="{{ route('community.link.create') }}">Submit a link</a> and help fellow developers discover great content. As a thank you, you'll receive a coupon for a discount on <a href="https://spatie.be/products">Spatie products</a>.
        </p>
    </div>

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
