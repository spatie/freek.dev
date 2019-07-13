@extends('front.layouts.app', [
    'title' => $post->title,
])

@section('content')
    @if($ad)
        <div class="markup | text-xs text-gray-700 mb-6 bg-yellow-100 p-2">
            {!! $ad->formatted_text !!}
        </div>
    @endif

    @component('front.posts.partials.post', [
        'post' => $post,
        'class' => 'mb-8',
    ])
        {!! $post->formatted_text !!}

        @unless($post->isTweet())
            @if($post->external_url)
                <p class="mt-6">
                    <a href="{{ $post->external_url }}">
                        Read more</a>
                    <span class="text-xs text-gray-700">[{{ $post->external_url_host }}]</span>
                </p>
            @endif
        @endunless
    @endcomponent

    @include('front.newsletter.partials.block', [
        'class' => 'mb-8',
    ])

    <div class="mb-8">
        @include('front.posts.partials.comments')
    </div>
@endsection

@section('seo')
    <meta property="og:title" content="{{ $post->title }} | freek.dev"/>
    <meta property="og:description" content="{{ $post->excerpt }}"/>

    @foreach($post->tags as $tag)
        <meta property="article:tag" content="{{ $tag->name }}"/>
    @endforeach
    <meta property="article:published_time" content="{{ optional($post->publish_date)->toIso8601String() }}"/>
    <meta property="og:updated_time" content="{{ $post->updated_at->toIso8601String() }}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="{{ $post->excerpt }}"/>
    <meta name="twitter:title" content="{{ $post->title }} | freek.dev"/>
    <meta name="twitter:site" content="@freekmurze"/>
    <meta name="twitter:image" content="https://freek.dev/images/avatar-boxed.jpg"/>
    <meta name="twitter:creator" content="@freekmurze"/>
@endsection
