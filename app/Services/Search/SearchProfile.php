<?php

namespace App\Services\Search;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\SiteSearch\Profiles\DefaultSearchProfile;

class SearchProfile extends DefaultSearchProfile
{
    public function shouldIndex(UriInterface $url, ResponseInterface $response): bool
    {
        if ($url->getPath() === '') {
            return false;
        }

        if (str_contains($url->getPath(), '?page=')) {
            return false;
        }

        return parent::shouldIndex($url, $response);
    }
}
