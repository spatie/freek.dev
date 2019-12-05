<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Spatie\Mailcoach\Events\CampaignLinkClickedEvent;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
    }
}
