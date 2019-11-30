<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class RemoveExternalUrlFromTextCommand extends Command
{
    protected $signature = 'blog:remove-external-url-from-text';

    protected $description = 'Remove the external url from the text field';

    public function handle()
    {
        Post::query()->whereNotNull('external_url')->each(
            fn (Post $post) => $post->update(['text' =>$this->getSanitizedText($post)])
        );
    }

    private function getSanitizedText(Post $post): string
    {
        $text = $post->text;

        $text = str_replace("[$post->external_url]($post->external_url)", '', $text);

        $text = str_replace($post->external_url, '', $text);

        return trim($text);
    }
}
