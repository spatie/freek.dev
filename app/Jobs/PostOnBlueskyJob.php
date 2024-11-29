<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NotificationChannels\Bluesky\BlueskyPost;

class PostOnBlueskyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public object $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(): void
    {
        if (! $this->post->send_automated_tweet) {
            return;
        }

        if ($this->post->posted_on_bluesky_at) {
            return;
        }

        if ($this->post->isTweet()) {
            return;
        }

        BlueskyPost::make()
            ->text($this->post->toBlueskyText())
            ->language(['en-US']);

        $this->post->update(['posted_on_bluesky_at' => true]);
    }
}
