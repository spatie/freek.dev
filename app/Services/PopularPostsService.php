<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PopularPostsService
{
    protected const CACHE_KEY = 'popular_posts';

    protected const CACHE_TTL_SECONDS = 60 * 60 * 24;

    public function __construct(protected AnalyticsService $analytics) {}

    public function getPopularPosts(int $limit = 5): Collection
    {
        $postIds = Cache::get(self::CACHE_KEY, []);

        if (empty($postIds)) {
            return collect();
        }

        return Post::query()
            ->published()
            ->whereIn('id', $postIds)
            ->get()
            ->sortBy(fn (Post $post) => array_search($post->id, $postIds))
            ->take($limit)
            ->values();
    }

    public function refreshCache(): void
    {
        try {
            $postIds = $this->analytics->getMostVisitedPosts(30, 50)->pluck('postId')->all();

            if ($postIds === []) {
                return;
            }

            Cache::put(self::CACHE_KEY, $postIds, self::CACHE_TTL_SECONDS);
        } catch (\Throwable $e) {
            Log::error('Failed to fetch popular posts from Google Analytics', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
