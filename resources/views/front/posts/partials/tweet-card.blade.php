<figure class="tweet-card">
    <figcaption class="tweet-card-author">
        <span class="tweet-card-avatar" aria-hidden="true">{{ mb_substr($post->shared_tweet_author, 0, 1) }}</span>
        <span>
            <strong>{{ $post->shared_tweet_author }}</strong>
            <span class="tweet-card-handle">{{ '@'.$post->sharedTweetHandle() }}</span>
        </span>
        <span class="tweet-card-mark" aria-label="On X">𝕏</span>
    </figcaption>
    <p class="tweet-card-text" dir="auto">{{ $post->shared_tweet_text }}</p>
    <div class="tweet-card-footer">
        <span>Worth sharing</span>
        <a href="{{ $post->shared_tweet_url }}" target="_blank" rel="noopener noreferrer">Read on X <span aria-hidden="true">↗</span></a>
    </div>
</figure>
