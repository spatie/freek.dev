<?php

namespace App\Providers;

use App\Http\Controllers\Discovery\Community\IndexController;
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
        Menu::macro('primary', fn () => Menu::new()
            ->url('/', 'Home')
            ->url('originals', 'Originals')
            ->url('community', 'Community')
            ->add(Link::to(url('/newsletter'), 'Newsletter')->addParentClass('mt-4'))
            ->add(Link::to(url('/speaking'), 'Speaking')->addParentClass('mt-4'))
            ->url('music', 'Music')
            ->url('uses', 'Uses')
            ->url('about', 'About')
            ->each(fn (Link $link) => $link->setAttribute('wire:navigate.hover'))
            ->setActiveFromRequest());

        Menu::macro('secondary', function () {
            return Menu::new()
                ->addClass('space-y-2')
                ->url('search', 'Search')
                ->url('advertising', 'Advertising')
                ->each(fn (Link $link) => $link->setAttribute('wire:navigate.hover'))
                ->setActiveFromRequest();
        });
    }
}
