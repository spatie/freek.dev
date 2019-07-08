@foreach($post->twitterReplies as $webmention)
    @include('front.posts.partials.webmention')
@endforeach

@foreach($post->twitterRetweets as $webmention)
    @include('front.posts.partials.webmention')
@endforeach

@foreach($post->twitterLikes as $webmention)
    @include('front.posts.partials.webmention')
@endforeach