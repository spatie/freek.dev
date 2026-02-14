<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class AnalyticsService
{
    protected const CACHE_TTL_SECONDS = 60 * 60;

    public function getOverviewStats(int $days = 30): array
    {
        return Cache::remember("analytics.overview.{$days}", self::CACHE_TTL_SECONDS, function () use ($days) {
            try {
                $dailyData = Analytics::fetchTotalVisitorsAndPageViews(Period::days($days), maxResults: $days + 1);

                $totalPageViews = $dailyData->sum('screenPageViews');
                $totalVisitors = $dailyData->sum('activeUsers');
                $avgDailyViews = $days > 0 ? round($totalPageViews / $days) : 0;

                $dailyPageViews = $dailyData->pluck('screenPageViews')->toArray();
                $dailyVisitors = $dailyData->pluck('activeUsers')->toArray();

                return [
                    'totalPageViews' => $totalPageViews,
                    'totalVisitors' => $totalVisitors,
                    'avgDailyViews' => $avgDailyViews,
                    'totalPostsPublished' => Post::query()
                        ->where('published', true)
                        ->where('publish_date', '>=', now()->subDays($days))
                        ->count(),
                    'dailyPageViews' => $dailyPageViews,
                    'dailyVisitors' => $dailyVisitors,
                ];
            } catch (\Throwable $e) {
                Log::error('Failed to fetch analytics overview stats', ['error' => $e->getMessage()]);

                return [
                    'totalPageViews' => 0,
                    'totalVisitors' => 0,
                    'avgDailyViews' => 0,
                    'totalPostsPublished' => 0,
                    'dailyPageViews' => [],
                    'dailyVisitors' => [],
                ];
            }
        });
    }

    public function getDailyVisitors(int $days = 30): Collection
    {
        return Cache::remember("analytics.daily.{$days}", self::CACHE_TTL_SECONDS, function () use ($days) {
            try {
                return Analytics::fetchTotalVisitorsAndPageViews(Period::days($days), maxResults: $days + 1);
            } catch (\Throwable $e) {
                Log::error('Failed to fetch daily visitors', ['error' => $e->getMessage()]);

                return collect();
            }
        });
    }

    public function getMostVisitedPages(int $days = 30, int $max = 50): Collection
    {
        return Cache::remember("analytics.pages.{$days}.{$max}", self::CACHE_TTL_SECONDS, function () use ($days, $max) {
            try {
                $pages = Analytics::fetchMostVisitedPages(Period::days($days), $max);

                return $pages->map(function (array $page) {
                    $postId = $this->extractPostId($page['fullPageUrl']);
                    $post = $postId ? Post::query()->where('published', true)->find($postId) : null;

                    return [
                        'url' => $page['fullPageUrl'],
                        'pageTitle' => $page['pageTitle'],
                        'pageViews' => $page['screenPageViews'],
                        'postId' => $postId,
                        'postTitle' => $post?->title,
                        'postUrl' => $post?->url,
                        'postType' => $post?->getType(),
                    ];
                });
            } catch (\Throwable $e) {
                Log::error('Failed to fetch most visited pages', ['error' => $e->getMessage()]);

                return collect();
            }
        });
    }

    public function getTopReferrers(int $days = 30, int $max = 20): Collection
    {
        return Cache::remember("analytics.referrers.{$days}.{$max}", self::CACHE_TTL_SECONDS, function () use ($days, $max) {
            try {
                return Analytics::fetchTopReferrers(Period::days($days), $max);
            } catch (\Throwable $e) {
                Log::error('Failed to fetch top referrers', ['error' => $e->getMessage()]);

                return collect();
            }
        });
    }

    public function getTopCountries(int $days = 30, int $max = 15): Collection
    {
        return Cache::remember("analytics.countries.{$days}.{$max}", self::CACHE_TTL_SECONDS, function () use ($days, $max) {
            try {
                return Analytics::fetchTopCountries(Period::days($days), $max);
            } catch (\Throwable $e) {
                Log::error('Failed to fetch top countries', ['error' => $e->getMessage()]);

                return collect();
            }
        });
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
