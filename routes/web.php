<?php

use Illuminate\Support\Facades\Route;
use Spatie\RouteDiscovery\Discovery\Discover;

Route::feeds('feed');
Route::webhooks('webhook-webmentions', 'webmentions');

Route::redirect('nova', '/nova/resources/post');
Route::redirect('links', '/community');
Route::redirect('me', '/about');
Route::redirect('php-version', '/1598-how-to-check-which-version-of-php-you-are-running');

Discover::views()->in(resource_path('views/discovery'));
Discover::controllers()->in(app_path('Http/Controllers/Discovery'));
