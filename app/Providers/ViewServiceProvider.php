<?php

namespace App\Providers;

use App\Http\ViewComposers\LazyViewComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        View::composer('front.components.lazy', LazyViewComposer::class);
    }
}
