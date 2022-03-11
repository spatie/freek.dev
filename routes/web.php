<?php

use Spatie\RouteDiscovery\Discovery\Discover;

Discover::views()->in(resource_path('views/discovery'));
Discover::controllers()->in(app_path('Http/Controllers/Discovery'));

Route::get('ray', function() {
   ray('Greetings from the server');

   return 'hello there';
});
