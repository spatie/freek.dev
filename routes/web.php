<?php

use Spatie\RouteDiscovery\Discovery\Discover;

Discover::views()->in(resource_path('views/discovery'));
Discover::controllers()->in(app_path('Http/Controllers/Discovery'));
