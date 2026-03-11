<?php

use Spatie\RouteDiscovery\PendingRouteTransformers\AddControllerUriToActions;
use Spatie\RouteDiscovery\PendingRouteTransformers\AddDefaultRouteName;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleDomainAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleDoNotDiscoverAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleFullUriAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleHttpMethodsAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleMiddlewareAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleRouteNameAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleUriAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleUrisOfNestedControllers;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleWheresAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\MoveRoutesStartingWithParametersLast;

return [
    /*
     * Routes will be registered for all controllers found in
     * these directories.
     */
    'discover_controllers_in_directory' => [
        // app_path('Http/Controllers'),
    ],

    /*
     * Routes will be registered for all views found in these directories.
     * The key of an item will be used as the prefix of the uri.
     */
    'discover_views_in_directory' => [
        // 'docs' => resource_path('views/docs'),
    ],

    /*
     * After having discovered all controllers, these classes will manipulate the routes
     * before registering them to Laravel.
     *
     * In most cases, you shouldn't change these.
     */
    'pending_route_transformers' => [
        HandleDoNotDiscoverAttribute::class,
        AddControllerUriToActions::class,
        HandleUrisOfNestedControllers::class,
        HandleRouteNameAttribute::class,
        HandleMiddlewareAttribute::class,
        HandleHttpMethodsAttribute::class,
        HandleUriAttribute::class,
        HandleFullUriAttribute::class,
        HandleWheresAttribute::class,
        AddDefaultRouteName::class,
        HandleDomainAttribute::class,
        MoveRoutesStartingWithParametersLast::class,
    ],
];
