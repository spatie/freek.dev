@extends('front.layouts.master')

@section('title', $post->formatted_title )

@section('content')
    @auth
        <div class="pb-4">
            <a class="button" target="_blank" href="/nova/resources/posts/{{ $post->id }}/edit">Edit</a>
        </div>
    @endauth
    <article class="max-w-3xl mx-auto px-12 py-12">
        <header class="max-w-xl mx-auto">
            <h1 class="font-title uppercase text-3xl leading-tight text-center">
                {{ $post->title }}
            </h1>
        </header>

        <div class="text-gray-darker text-sm pb-6 border-b text-gray">
            Posted on <time datetime="{{ optional($post->publish_date)->format(DateTime::ATOM) }}">{{ $post->publish_date }}</time> | {{ $post->author }}
        </div>

        <div class="pt-4 post-content">
            {!! $post->formatted_text !!}
        </div>

        @if (! empty($this->external_url))
            <a href="{{ $this->external_url }}">{{ $this->external_url }}</a>
        @endif
    </article>

    <div class="pt-4">
        @include('front.posts.partials.tags')
    </div>

    <div class="pt-4">
        @include('front.posts.partials.newsletter')
    </div>

     <div class="pt-4">
        @include('front.posts.partials.disqus')
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
