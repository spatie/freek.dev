<?php

namespace App\Jobs;

use App\Models\Concerns\Tweetable;
use App\Models\Post;
use App\Services\Twitter\Twitter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPostTweetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public object $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(Twitter $twitter)
    {
        $tweetText = $this->post->toTweet();

        $tweetResponse = $twitter->tweet($tweetText);

        $tweetUrl = "https://twitter.com/freekmurze/status/{$tweetResponse['id_str']}";

        $this->post->onAfterTweet($tweetUrl);
    }
}
