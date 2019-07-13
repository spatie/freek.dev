<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\Twitter\PublicTwitter;
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

        $tweetResponse = $twitter->tweet($tweetText);

        if ($this->post->isOriginal()) {
            info('is original');
            $tweetUrl = "https://twitter.com/TwitterAPI/status/{$tweetResponse['id_str']}";

            $this->post->tweet_url = $tweetUrl;
            info($tweetUrl);
            $this->post->embed_tweet_html = $this->getTweetEmbedHtml($tweetUrl);
            info($this->post->embed_tweet_html);
            $this->post->save();
            info('saved');
        }
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

    private function getTweetEmbedHtml(string $tweetUrl): string
    {
        return app(PublicTwitter::class)->getEmbedHtml($tweetUrl);
    }
}
