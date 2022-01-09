<?php

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
        Spatie\RouteDiscovery\PendingRouteTransformers\HandleDoNotDiscoverAttribute::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\AddControllerUriToActions::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\HandleUrisOfNestedControllers::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\HandleRouteNameAttribute::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\HandleMiddlewareAttribute::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\HandleHttpMethodsAttribute::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\HandleUriAttribute::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\HandleFullUriAttribute::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\HandleWheresAttribute::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\AddDefaultRouteName::class,
        Spatie\RouteDiscovery\PendingRouteTransformers\HandleDomainAttribute::class,
    ],
];
