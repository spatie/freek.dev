<?php

use Spatie\RouteDiscovery\Discovery\Discover;

Route::redirect('nova', '/nova/resources/posts');

Discover::views()->in(resource_path('views/discovery'));
Discover::controllers()->in(app_path('Http/Controllers/Discovery'));


