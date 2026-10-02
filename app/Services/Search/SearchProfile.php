<?php

namespace App\Services\Search;

use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlResponse;
use Spatie\SiteSearch\Profiles\DefaultSearchProfile;

class SearchProfile extends DefaultSearchProfile
{
    public const USER_AGENT = 'freek.dev site search crawler';

    public function configureCrawler(Crawler $crawler): void
    {
        $crawler
            ->userAgent(self::USER_AGENT)
            ->concurrency(1)
            ->delay(100);
    }

    public function shouldIndex(string $url, CrawlResponse $response): bool
    {
        $path = parse_url($url, PHP_URL_PATH);

        if ($path === '' || $path === '/') {
            return false;
        }

        if (str_contains($url, '?page=') || str_contains($url, 'utm_')) {
            return false;
        }

        return parent::shouldIndex($url, $response);
    }
}
