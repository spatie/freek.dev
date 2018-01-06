<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\View;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Menu::macro('main', function () {
            return Menu::new()
                ->addClass('list-reset lg:flex justify-end items-center')
                ->addItemClass('block border-b-2 border-transparent py-2 px-4 text-center align-content-center lg:mx-6')
                ->action('Front\HomeController@index', 'Home')
                ->action('Front\OriginalsController@index', 'Originals')
                ->action('Front\NewsletterController@index', 'Newsletter')
                ->url('/advertising', 'Advertising')
                ->action('Front\MeController@index', 'Me')
                ->add(View::create('front.layouts._partials.search')->addParentClass('items-center mt-4 lg:mt-0'))
                ->setActiveFromRequest('/');
        });

        Menu::macro('back', function () {
            return Menu::new()
                ->addClass('list-reset flex flex-col lg:flex-row justify-end items-center mb-8')
                ->addItemClass('block rounded py-2 text-center align-content-center mx-6')
                ->action('Back\PostsController@index', 'Posts')
                ->action('Back\NewsletterGeneratorController@index', 'Newsletter')
                ->view('back.layouts._partials.logout')
                ->setActiveFromRequest('/');
        });
    }
}
