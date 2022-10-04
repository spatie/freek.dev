<?php

use Illuminate\Support\Facades\Route;
use Spatie\RouteDiscovery\Discovery\Discover;

Discover::views()->in(resource_path('views/discovery'));
Discover::controllers()->in(app_path('Http/Controllers/Discovery'));

Route::redirect('/admin', '/admin/posts');
