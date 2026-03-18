<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\OgImage\Facades\OgImage;
use Throwable;

#[Signature('app:preheat-og-images')]
#[Description('Pre-generate OG images for all public pages')]
class PreheatOgImagesCommand extends Command
{
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

    protected function collectUrls(): Collection
    {
        $postUrls = Post::query()
            ->published()
            ->latest('publish_date')
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

        return $postUrls->merge($staticUrls)->values();
    }
}
