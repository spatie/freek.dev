@foreach($post->twitterReplies as $webmention)
    reply
@endforeach

@foreach($post->twitterRetweets as $webmention)
    retweet
@endforeach

@foreach($post->twitterLikes as $webmention)
    like
@endforeach