<?php

namespace App\Providers;

use App\Http\Controllers\Discovery\Community\IndexController;
use App\Http\Controllers\Discovery\HomeController;
use App\Http\Controllers\Discovery\MusicController;
use App\Http\Controllers\Discovery\NewsletterController;
use App\Http\Controllers\Discovery\OriginalsController;
use App\Http\Controllers\Discovery\SpeakingController;
use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Link;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Menu::macro('primary', function () {
            return Menu::new()
                ->action(HomeController::class, 'Home')
                ->action(OriginalsController::class, 'Originals')
                ->action(IndexController::class, 'Community')
                ->add(Link::to(action(NewsletterController::class), 'Newsletter')->addParentClass('mt-4'))
                ->add(Link::to(action(SpeakingController::class), 'Speaking')->addParentClass('mt-4'))
                ->action(MusicController::class, 'Music')
                ->url('uses', 'Uses')
                ->url('about', 'About')
                ->setActiveFromRequest();
        });

        Menu::macro('secondary', function () {
            return Menu::new()
                ->addClass('space-y-2')
                ->url('search', 'Search')
                ->url('advertising', 'Advertising')

                ->setActiveFromRequest();
        });
    }
}
