<?php

namespace App\Models;

use App\Http\Controllers\NewsletterController;
use App\Models\Concerns\Tweetable;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model implements Tweetable
{
    public $dates = ['sent_at'];

    public function toTweet(): string
    {
        $tweet = [
            "I've just sent {$this->title}",
            '',
            'Want to receive the next edition in your mailbox?',
            'Subscribe here: ' . url(action(NewsletterController::class)),
        ];

        return implode(PHP_EOL, $tweet);
    }

    public function onAfterTweet(string $tweetUrl): void
    {
    }
}
