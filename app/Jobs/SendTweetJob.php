<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\Twitter\Twitter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Tags\Tag;

class SendTweetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \App\Models\Post */
    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(Twitter $twitter)
    {
        $tweetText = $this->toTweet($this->post);

        $twitter->tweet($tweetText);
    }

    protected function toTweet(Post $post): string
    {
        $tags = $post->tags
            ->map(function (Tag $tag) {
                return $tag->name;
            })
            ->map(function (string $tagName) {
                return '#' . str_replace(' ', '', $tagName);
            })
            ->implode(' ');

        $title = $post->title;

        return $post->emoji . ' ' . $title
            . PHP_EOL . $post->promotional_url
            . PHP_EOL . $tags;
    }
}
