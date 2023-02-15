<?php

namespace App\Providers;

use App\Http\Livewire\SearchComponent;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('search', SearchComponent::class);
    }
}
