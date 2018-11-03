@extends('front.layouts.master')

@section('title', $post->formatted_title )

@section('content')

    @auth
        <div class="pb-4">
            <a class="button" target="_blank" href="/nova/resources/posts/{{ $post->id }}/edit">Edit</a>
        </div>
    @endauth

    @if($ad)
        <div class="bg-white border-2 rounded mb-4 py-4 px-6 mt-4 text-xs">
            {!! $ad->formatted_text !!}
        </div>
    @endif

    <h1>{{ $post->formatted_title }}</h1>

    <div class="text-grey-darker text-sm pb-6 border-b text-grey">
        Posted on <time datetime="{{ optional($post->publish_date)->format(DateTime::ATOM) }}">{{ $post->publish_date }}</time> | {{ $post->author }}
    </div>

    <div class="pt-4 post-content">
        {!! $post->formatted_text !!}
    </div>

    <div class="pt-4">
        @include('front.posts._partials.tags')
    </div>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Detail pages -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-2689560793157981"
         data-ad-slot="2810918527"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

    <div class="pt-4">
        @include('front.posts._partials.disqus')
    </div>


@endsection

@section('seo')
    <meta property="og:title" content="{{ $post->title }} | murze.be"/>
    <meta property="og:description" content="{{ $post->excerpt }}"/>

    @foreach($post->tags as $tag)
        <meta property="article:tag" content="{{ $tag->name }}"/>
    @endforeach
    <meta property="article:published_time" content="{{ optional($post->publish_date)->toIso8601String() }}"/>
    <meta property="og:updated_time" content="{{ $post->updated_at->toIso8601String() }}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="{{ $post->excerpt }}"/>
    <meta name="twitter:title" content="{{ $post->title }} | murze.be"/>
    <meta name="twitter:site" content="@freekmurze"/>
    <meta name="twitter:image" content="https://murze.be/images/avatar-boxed.jpg"/>
    <meta name="twitter:creator" content="@freekmurze"/>
@endsection
