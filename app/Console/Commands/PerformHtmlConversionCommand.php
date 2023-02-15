<?php

namespace App\Console\Commands;

use App\Actions\ConvertPostTextToHtmlAction;
use App\Models\Ad;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Console\Command;

class PerformHtmlConversionCommand extends Command
{
    protected $signature = 'blog:perform-html-conversion';

    protected $description = 'Command description';

    public function handle(): void
    {
        $this->info('Performing HTML conversions...');

        Video::each(function (Video $video) {
            $video->touch();

            $this->comment("Conversion done for video `{$video->id}`");
        });

        Ad::each(function (Ad $ad) {
            $ad->touch();

            $this->comment("Conversion done for ad `{$ad->id}`");
        });

        Post::all()->reverse()->each(function (Post $post) {
            (new ConvertPostTextToHtmlAction())->execute($post);

            $this->comment("Conversion done for post `{$post->id}`");
        });

        $this->info('All done!');
    }
}
