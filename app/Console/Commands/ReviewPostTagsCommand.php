<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Services\TaggingService;
use Illuminate\Console\Command;
use Prism\Prism\Exceptions\PrismRateLimitedException;
use Throwable;

class ReviewPostTagsCommand extends Command
{
    protected $signature = 'app:review-post-tags
        {--dry-run : Show suggested changes without applying them}
        {--post= : Review a specific post by ID}';

    protected $description = 'Review and update tags for all published posts using AI';

    public function handle(TaggingService $taggingService): void
    {
        $query = Post::query()->published();

        if ($postId = $this->option('post')) {
            $query->where('id', $postId);
        }

        $posts = $query->get();

        $this->info("Reviewing tags for {$posts->count()} posts...");

        $changed = 0;

        foreach ($posts as $post) {
            try {
                $currentTags = $post->tags
                    ->pluck('name')
                    ->map(fn ($name) => is_array($name) ? ($name['en'] ?? reset($name)) : $name)
                    ->sort()
                    ->values()
                    ->all();

                $suggestedTags = $this->generateTagsWithRetry($taggingService, $post);
                sort($suggestedTags);

                if ($currentTags === $suggestedTags) {
                    continue;
                }

                $changed++;

                $this->warn("#{$post->id}: {$post->title}");
                $this->line('  Current:   '.implode(', ', $currentTags));
                $this->line('  Suggested: '.implode(', ', $suggestedTags));

                if (! $this->option('dry-run')) {
                    $post->syncTags($suggestedTags);
                    $this->info('  -> Updated');
                }

                $this->newLine();
            } catch (Throwable $e) {
                $this->error("#{$post->id}: {$post->title} — skipped ({$e->getMessage()})");
            }
        }

        $this->info("Done. {$changed} post(s) ".($this->option('dry-run') ? 'would be updated.' : 'updated.'));
    }

    private function generateTagsWithRetry(TaggingService $taggingService, Post $post, int $maxRetries = 3): array
    {
        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                return $taggingService->generateTags($post);
            } catch (PrismRateLimitedException $e) {
                if ($attempt === $maxRetries) {
                    throw $e;
                }

                $retryAfter = $e->retryAfter ?? 60;
                $this->warn("  Rate limited — waiting {$retryAfter}s...");
                sleep($retryAfter);
            }
        }

        return []; // unreachable
    }
}
