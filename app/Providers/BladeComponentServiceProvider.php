<?php

namespace App\Providers;

use App\Http\Components\AdComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeComponentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::component('ad', AdComponent::class);

        Blade::component('front.components.inputField', 'input-field');
        Blade::component('front.components.submitButton', 'submit-button');
        Blade::component('front.components.textarea', 'textarea');
        Blade::component('front.components.textarea', 'textarea');
        Blade::component('front.components.shareButton', 'share-button');

        Blade::component('front.layouts.app', 'app-layout');
    }
}
