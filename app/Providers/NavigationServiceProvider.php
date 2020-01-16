<?php

namespace App\Providers;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Links\LinksIndexController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OriginalsController;
use App\Http\Controllers\SpeakingController;
use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Menu;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Menu::macro('primary', function () {
            return Menu::new()
                ->action(HomeController::class, 'Home')
                ->action(OriginalsController::class, 'Originals')
                ->action(NewsletterController::class, 'Newsletter')
                ->action(SpeakingController::class, 'Speaking')
                ->url('about', 'About')
                ->setActiveFromRequest('/');
        });

        Menu::macro('secondary', function () {
            return Menu::new()
                ->url('search', 'Search')
                ->url('advertising', 'Advertising')
                ->action(LinksIndexController::class, 'Submit a link')
                ->setActiveFromRequest('/');
        });
    }
}
