@extends('front.layouts.master')

@section('title', $post->title)

@section('content')

    <h1>{{ $post->title }}</h1>

    <div class="text-grey-darker text-sm pb-6 border-b text-grey">
        Posted on {{ $post->publish_date }} | {{ $post->author }}
    </div>

    <div class="pt-4 post-content">
        {!! $post->text !!}
    </div>

    <div class="pt-4">
        @include('front.posts._partials.tags')
    </div>


@endsection

@section('seo')
    <meta property="og:title" content="{{ $post->title }} | murze.be" />
    <meta property="og:description" content="{{ $post->excerpt }}" />

    @foreach($post->tags as $tag)
        <meta property="article:tag" content="{{ $tag->name }}" />
    @endforeach
    <meta property="article:published_time" content="{{ $post->publish_date->toIso8601String() }}" />
    <meta property="og:updated_time" content="{{ $post->updated_at->toIso8601String() }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="{{ $post->excerpt }}" />
    <meta name="twitter:title" content="{{ $post->title }} | murze.be" />
    <meta name="twitter:site" content="@freekmurze" />
    <meta name="twitter:image" content="https://murze.be/images/avatar-boxed.jpg" />
    <meta name="twitter:creator" content="@freekmurze" />
@endsection