<?php

namespace App\Jobs;

use App\Models\Concerns\Tweetable;
use App\Services\Twitter\Twitter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTweetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \App\Models\Concerns\Tweetable */
    public $tweetable;

    public function __construct(Tweetable $tweetable)
    {
        $this->tweetable = $tweetable;
    }

    public function handle(Twitter $twitter)
    {
        $tweetText = $this->tweetable->toTweet();

        $tweetResponse = $twitter->tweet($tweetText);

        $tweetUrl = "https://twitter.com/freekmurze/status/{$tweetResponse['id_str']}";

        $this->tweetable->onAfterTweet($tweetUrl);
    }
}
