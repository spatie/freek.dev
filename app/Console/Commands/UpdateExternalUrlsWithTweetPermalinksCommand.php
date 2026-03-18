<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('blog:update-external-urls-with-tweet-permalinks')]
#[Description('Update external links with tweet permalinks')]
class UpdateExternalUrlsWithTweetPermalinksCommand extends Command
{
    public function handle(): void
    {
        Post::all()
            ->filter->isTweet()
            ->filter(function (Post $post) {
                return empty($post->external_url);
            })
            ->each(function (Post $post) {
                $permalink = $this->getPermalink($post->text);

                $post->external_url = $permalink;
                $post->save();
            });

        $this->info('All done!');
    }

    private function getPermalink(string $text): string
    {
        preg_match('/(?=https:\/\/twitter.com\/).+?(?=")/', $text, $matches);

        return $matches[0];
    }
}
