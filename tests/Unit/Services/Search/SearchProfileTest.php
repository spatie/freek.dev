<?php

use App\Services\Search\SearchProfile;
use Spatie\Crawler\Crawler;

it('crawls with a recognizable user agent', function () {
    $crawler = Crawler::create('https://freek.dev');

    (new SearchProfile)->configureCrawler($crawler);

    expect($crawler->getUserAgent())->toBe('freek.dev site search crawler');
});
