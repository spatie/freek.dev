@if ($post->tweet_url)
    @include('front.posts.partials.webmentions')
@else
    @component('front.components.lazy')
        @include('front.posts.partials.disqus')
    @endcomponent
@endif
