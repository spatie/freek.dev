<?php

namespace App\Jobs;

class CrawlSiteJob extends \Spatie\SiteSearch\Jobs\CrawlSiteJob
{
    public $timeout = 60 * 30;

}
