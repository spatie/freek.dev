<?php

namespace App\Services\Search;

use Spatie\SiteSearch\Indexers\DefaultIndexer;

class Indexer extends DefaultIndexer
{
    public function pageTitle(): ?string
    {
        return str_replace(
            " - Freek Van der Herten's blog on PHP, Laravel and JavaScript",
            '',
            parent::pageTitle()
        );
    }
}
