@if (! $post->tweet_url)
    <div class="mb-8">
        @component('front.components.lazy')
            @include('front.posts.partials.disqus')
        @endcomponent
    </div>
@endif

<div class="markup mb-8">
    <h2 id="comments">
        Comments
        <a href="#comments" class="permalink">#</a>
    </h2>
</div>

<script src="https://utteranc.es/client.js"
        repo="freekmurze/freek-dev-comments"
        issue-term="pathname"
        theme="github-light"
        crossorigin="anonymous"
        async>
</script>

@include('front.posts.partials.webmentions')
