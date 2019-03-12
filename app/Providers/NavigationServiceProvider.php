<?php

namespace App\Providers;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OriginalsController;
use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\View;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Menu::macro('main', function () {
            return Menu::new()
                ->action([HomeController::class, 'index'], 'Home')
                ->action([OriginalsController::class, 'index'], 'Originals')
                ->action([NewsletterController::class, 'index'], 'Newsletter')
                // ->url('/advertising', 'Advertising')
                ->action([MeController::class, 'index'], 'Me')
                // ->add(View::create('front.layouts.partials.search')
                ->setActiveFromRequest('/');
        });
    }
}
