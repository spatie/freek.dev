<?php

use Spatie\RouteDiscovery\Discovery\Discover;

Route::redirect('nova', '/nova/resources/posts');

Route::get('debug', function() {
   ray('greetings from your server');

   return 'ok!';
});

Discover::views()->in(resource_path('views/discovery'));
Discover::controllers()->in(app_path('Http/Controllers/Discovery'));


