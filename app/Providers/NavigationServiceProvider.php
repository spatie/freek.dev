<?php

namespace App\Providers;

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OriginalsController;
use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Menu;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Menu::macro('main', function () {
            return Menu::new()
                ->action(HomeController::class, 'Home')
                ->action(OriginalsController::class, 'Originals')
                ->action([NewsletterController::class, 'index'], 'Newsletter')
                ->url('/advertising', 'Advertising')
                ->action(AboutController::class, 'About')
                ->url('#', 'Search')
                ->setActiveFromRequest('/');
        });
    }
}
