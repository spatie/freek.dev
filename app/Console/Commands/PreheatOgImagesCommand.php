<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\OgImage\Facades\OgImage;
use Throwable;

class PreheatOgImagesCommand extends Command
{
    protected $signature = 'app:preheat-og-images';

    protected $description = 'Pre-generate OG images for all public pages';

    public function handle(): void
    {
        $urls = $this->collectUrls();

        $this->info("Generating OG images for {$urls->count()} URLs...");

        $bar = $this->output->createProgressBar($urls->count());
        $bar->start();

        $failures = 0;

        foreach ($urls as $url) {
            try {
                OgImage::generateForUrl($url);
            } catch (Throwable $e) {
                $failures++;
                $this->newLine();
                $this->error("Failed: {$url} - {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $successes = $urls->count() - $failures;
        $this->info("Done! {$successes} succeeded, {$failures} failed.");
    }

    protected function collectUrls(): \Illuminate\Support\Collection
    {
        $postUrls = Post::query()
            ->published()
            ->get()
            ->reject(fn (Post $post) => $post->isTweet())
            ->map(fn (Post $post) => $post->url);

        $staticUrls = collect([
            url('/'),
            url('/about'),
            url('/advertising'),
            url('/legal'),
            url('/search'),
            url('/music'),
            url('/originals'),
            url('/speaking'),
            url('/uses'),
            url('/newsletter'),
            url('/community'),
        ]);

        return $staticUrls->merge($postUrls)->values();
    }
}
