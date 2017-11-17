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
                ->addClass('list-reset flex flex-col lg:flex-row justify-end')
                ->addItemClass('block rounded py-2 px-4 text-center align-content-center mx-6')
                ->action('Front\HomeController@index', 'Home')
                ->action('Front\NewsletterController@index', 'Newsletter')
                ->action('Front\TalksController@index', 'Talks')
                ->action('Front\AboutController@index', 'About')
                ->add(View::create('front.layouts._partials.search')->addParentClass('flex justify-center items-center'))
                ->setActiveFromRequest('/');
        });


        Menu::macro('back', function () {
            return Menu::new()
                ->addClass('list-reset flex flex-col lg:flex-row align-center')
                ->addItemClass('block rounded py-2 px-4 text-center align-content-center mx-6')
                ->action('Back\PostsController@index', 'Posts')
                ->action('Back\NewsletterGeneratorController@index', 'Newsletter')
                ->view('back.layouts._partials.logout')
                ->setActiveFromRequest('/');
        });
    }
}
