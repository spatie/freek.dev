<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NotificationChannels\Bluesky\BlueskyService;
use NotificationChannels\Bluesky\Embeds\External;

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

        if ($this->post->posted_on_bluesky) {
            return;
        }

        if ($this->post->isTweet()) {
            return;
        }

        $blueskyPost = BlueskyPost::make()
            ->text($this->post->toBlueskyText())
            ->withoutAutomaticEmbeds()
            ->language(['en-US'])
            ->embed(new External(
                uri: $this->post->title,
                title: $this->post->title,
                description: $this->post->text,
            ));

        app(BlueskyService::class)->createPost($blueskyPost);

        $this->post->update(['posted_on_bluesky_at' => true]);
    }
}
