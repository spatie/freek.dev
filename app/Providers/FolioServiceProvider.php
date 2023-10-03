<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;
use Spatie\ResponseCache\Middlewares\CacheResponse;

class FolioServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Folio::path(resource_path('views/pages'))->uri('/')->middleware(['*' => [CacheResponse::class]]);
    }
}
