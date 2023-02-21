<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class TootPostJob implements ShouldQueue
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

        if ($this->post->toot_sent) {
            return;
        }

        if ($this->post->isTweet()) {
            return;
        }

        Http::withToken(config('services.mastodon.token'))
            ->post('https://phpc.social/api/v1/statuses', [
                'status' => $this->post->toToot(),
            ]);

        $this->post->update(['toot_sent' => true]);
    }
}
