@extends('front.layouts.master')

@section('title', $post->formatted_title)

@section('content')
    @component('front.posts.partials.post', [
        'post' => $post,
    ])
        {!! $post->formatted_text !!}
    @endcomponent
    {{--<div class="pt-4">
        @include('front.posts.partials.newsletter')
    </div>

     <div class="pt-4">
        @include('front.posts.partials.disqus')
    </div> --}}
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
