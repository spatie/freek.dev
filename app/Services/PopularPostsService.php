<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class PopularPostsService
{
    protected const CACHE_KEY = 'popular_posts';

    protected const CACHE_TTL_SECONDS = 60 * 60 * 24;

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
            $pages = Analytics::fetchMostVisitedPages(Period::days(30), 50);

            $postIds = $pages
                ->map(fn (array $page) => $this->extractPostId($page['fullPageUrl']))
                ->filter()
                ->unique()
                ->values()
                ->all();

            Cache::put(self::CACHE_KEY, $postIds, self::CACHE_TTL_SECONDS);
        } catch (\Throwable $e) {
            Log::error('Failed to fetch popular posts from Google Analytics', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function extractPostId(string $url): ?int
    {
        if (! str_contains($url, '://')) {
            $url = 'https://'.$url;
        }

        $path = parse_url($url, PHP_URL_PATH);

        if (! $path) {
            return null;
        }

        $path = ltrim($path, '/');

        if (! preg_match('/^(\d+)-/', $path, $matches)) {
            return null;
        }

        return (int) $matches[1];
    }
}
