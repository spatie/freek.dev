<?php

namespace App\Services\Search;

use Spatie\Crawler\CrawlResponse;
use Spatie\SiteSearch\Profiles\DefaultSearchProfile;

class SearchProfile extends DefaultSearchProfile
{
    public function shouldIndex(string $url, CrawlResponse $response): bool
    {
        $path = parse_url($url, PHP_URL_PATH);

        if ($path === '' || $path === '/') {
            return false;
        }

        if (str_contains($url, '?page=')) {
            return false;
        }

        return parent::shouldIndex($url, $response);
    }
}
