<?php

use Spatie\RouteDiscovery\Discovery\Discover;

Route::get('ray', function() {
    ray('Greetings from the server');

    return 'hello there';
});

Discover::views()->in(resource_path('views/discovery'));
Discover::controllers()->in(app_path('Http/Controllers/Discovery'));


