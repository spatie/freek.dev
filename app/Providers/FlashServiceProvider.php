<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;

class FlashServiceProvider extends ServiceProvider
{
    public function register()
    {
        Flash::levels([
            'success' => 'bg-green-400',
            'error' => 'bg-red-400',
        ]);
    }
}
