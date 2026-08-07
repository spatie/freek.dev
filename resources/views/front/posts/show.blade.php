<x-app-layout :title="$post->title" :description="$post->plain_text_excerpt" :canonical="$canonical ?? $post->external_url">
    <x-post-header :post="$post" class="mb-8" :showTags="true">

        {!! $post->html_with_utm !!}

        @unless($post->isTweet())
            @if($post->external_url)
                <p class="mt-6">
                    <a href="{{ $post->external_url_with_utm }}" target="_blank" rel="noopener noreferrer">
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

    <div class="mb-8 giscus">
        <script src="https://giscus.app/client.js"
                data-repo="spatie/freek-dev-comments"
                data-repo-id="R_kgDORRFS6Q"
                data-category="Announcements"
                data-category-id="DIC_kwDORRFS6c4C2gru"
                data-mapping="pathname"
                data-strict="0"
                data-reactions-enabled="1"
                data-emit-metadata="0"
                data-input-position="top"
                data-theme="light"
                data-lang="en"
                data-loading="lazy"
                crossorigin="anonymous"
                async>
        </script>
    </div>

    @include('front.newsletter.partials.block', [
        'class' => 'mb-8',
    ])

    @include('front.posts.partials.keep-reading')

    <p data-no-index class="text-sm text-gray-600 mb-8">
        Found something interesting to share? <a href="{{ route('community.link.create') }}" class="underline hover:text-black">Submit a link</a> to the <a href="{{ route('community.index') }}" class="underline hover:text-black">community section</a>.
    </p>

    @unless($post->isTweet())
        <x-og-image view="og-images.post" :data="['post' => $post]" />
    @endunless

    <x-slot name="seo">
        <meta property="og:type" content="article"/>
        <meta property="og:title" content="{{ $post->title }} | freek.dev"/>

        @foreach($post->tags as $tag)
            <meta property="article:tag" content="{{ $tag->name }}"/>
        @endforeach

        <meta property="article:published_time" content="{{ $post->publish_date?->toIso8601String() }}"/>
        <meta property="og:updated_time" content="{{ $post->updated_at->toIso8601String() }}"/>
        <meta name="twitter:title" content="{{ $post->title }} | freek.dev"/>
        <meta name="twitter:site" content="@freekmurze"/>
        <meta name="twitter:creator" content="@freekmurze"/>

        <x-schema-markup
            :post="$post"
            :breadcrumbs="[
                ['name' => 'Home', 'url' => route('home')],
                ['name' => $post->isOriginal() ? 'Originals' : 'Home', 'url' => $post->isOriginal() ? route('originals') : route('home')],
                ['name' => $post->title, 'url' => $post->url],
            ]"
        />
    </x-slot>
</x-app-layout>
