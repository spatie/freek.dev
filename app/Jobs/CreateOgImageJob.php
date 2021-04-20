<?php

namespace App\Jobs;

use App\Models\Post;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;
use Spatie\ResponseCache\Facades\ResponseCache;

class CreateOgImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;

    public function __construct(
        public Post $post
    ) {
    }

    public function handle()
    {
        if ($this->post->isTweet()) {
            return;
        }

        try {
            $base64Image = Browsershot::url($this->post->ogImageBaseUrl())
                ->devicePixelRatio(2)
                ->windowSize(1200, 630)
                ->base64Screenshot();

            $this
                ->post
                ->addMediaFromBase64($base64Image)
                ->usingFileName("{$this->post->id}.png")
                ->toMediaCollection('ogImage');
        } catch (Exception $exception) {
            report($exception);
        }

        ResponseCache::clear();
    }
}
