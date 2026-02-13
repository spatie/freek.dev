<?php

namespace App\Actions;

use App\Jobs\ComputeRelatedPostsJob;
use App\Jobs\CreateOgImageJob;
use App\Jobs\GeneratePostEmbeddingJob;
use App\Jobs\GeneratePostTagsJob;
use App\Jobs\PurgeCloudflareCacheJob;
use App\Models\Post;
use Illuminate\Support\Facades\Bus;
use Spatie\ResponseCache\Facades\ResponseCache;

class HandlePostSavedAction
{
    public function execute(Post $post): void
    {
        Post::withoutEvents(function () use ($post) {
            (new ConvertPostTextToHtmlAction)->execute($post);

            if ($post->isPartOfSeries()) {
                $post->getAllPostsInSeries()->each(function (Post $post) {
                    (new ConvertPostTextToHtmlAction)->execute($post);
                });
            }
        });

        if (app()->runningUnitTests()) {
            return;
        }

        if ($post->published) {
            Post::withoutEvents(function () use ($post) {
                (new PublishPostAction)->execute($post);
            });

            if (config('openai.api_key')) {
                Bus::chain([
                    //new GeneratePostEmbeddingJob($post),
                    //new ComputeRelatedPostsJob($post),
                ])->dispatch();
            }

            if (config('prism.providers.anthropic.api_key') && $post->tags->isEmpty()) {
                GeneratePostTagsJob::dispatch($post);
            }

            return;
        }

        Bus::chain([
            new CreateOgImageJob($post),
            fn () => ResponseCache::clear(),
            new PurgeCloudflareCacheJob,
        ])->dispatch();
    }
}
