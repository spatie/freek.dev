<?php

namespace App\Providers;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Links\LinksIndexController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\MySetupController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OriginalsController;
use App\Http\Controllers\SpeakingController;
use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Link;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Menu::macro('primary', function () {
            return Menu::new()
                ->action(HomeController::class, 'Home')
                ->action(OriginalsController::class, 'Originals')
                ->action(LinksIndexController::class, 'Community')

                ->add(Link::to(action(NewsletterController::class), 'Newsletter')->addParentClass('mt-4'))

                ->add(Link::to(action(SpeakingController::class), 'Speaking')->addParentClass('mt-4'))
                ->action(MusicController::class, 'Music')
                ->url('about', 'About')
                ->setActiveFromRequest();
        });

        Menu::macro('secondary', function () {
            return Menu::new()
                ->addClass('space-y-2')
                ->url('search', 'Search')
                /*
                ->url('laravel-package-training-contest', 'Package training contest')
                ->url('mailcoach-contest', 'Mailcoach contest')
                ->url('ohdear-contest', 'Oh Dear contest')
                */
                ->action(MySetupController::class, 'My setup')
                ->url('advertising', 'Advertising')

                ->setActiveFromRequest('/');
        });
    }
}
