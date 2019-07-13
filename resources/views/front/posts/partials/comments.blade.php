@if (! $post->tweet_url)
    <div class="mb-8">
        @component('front.components.lazy')
            @include('front.posts.partials.disqus')
        @endcomponent
    </div>
@endif

@include('front.posts.partials.webmentions')
