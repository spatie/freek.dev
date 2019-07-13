@if (! $post->tweet_url)
    @component('front.components.lazy')
        @include('front.posts.partials.disqus')
    @endcomponent
@endif

@include('front.posts.partials.webmentions')
