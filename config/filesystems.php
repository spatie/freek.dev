<?php

/*
 * When assets live on object storage, every disk is scoped to the directory matching its public URL
 * segment and generates freek.dev URLs. Those URLs are served by ServeObjectStorageAssetController,
 * so content never contains URLs that point to the storage backend.
 */
$objectStorageDisk = fn (string $directory): array => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'auto'),
    'bucket' => env('AWS_BUCKET'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'root' => $directory,
    'url' => env('APP_URL'),
    'throw' => false,
    'report' => false,
];

$assetsOnObjectStorage = (bool) env('ASSETS_ON_OBJECT_STORAGE', false);

return [

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    'assets_on_object_storage' => $assetsOnObjectStorage,

    /*
     * Maps the first URL segment of a public asset to the disk it is stored on.
     */
    'asset_url_segments' => [
        'uploads' => 'uploads',
        'admin-uploads' => 'admin-uploads',
        'avatars' => 'avatars',
        'fonts' => 'fonts',
        'storage' => 'public',
    ],

    'disks' => [
        'public' => $assetsOnObjectStorage
            ? $objectStorageDisk('storage')
            : [
                'driver' => 'local',
                'root' => storage_path('app/public'),
                'url' => rtrim((string) env('APP_URL'), '/').'/storage',
                'visibility' => 'public',
                'throw' => false,
                'report' => false,
            ],

        'uploads' => $assetsOnObjectStorage
            ? $objectStorageDisk('uploads')
            : [
                'driver' => 'local',
                'root' => public_path('uploads'),
                'url' => env('APP_URL').'/uploads',
                'visibility' => 'public',
            ],

        'admin-uploads' => $assetsOnObjectStorage
            ? $objectStorageDisk('admin-uploads')
            : [
                'driver' => 'local',
                'root' => storage_path('admin-uploads'),
                'url' => env('APP_URL').'/admin-uploads',
                'visibility' => 'public',
            ],

        'avatars' => $assetsOnObjectStorage
            ? $objectStorageDisk('avatars')
            : [
                'driver' => 'local',
                'root' => storage_path('avatars'),
                'url' => env('APP_URL').'/avatars',
                'visibility' => 'public',
            ],

        'fonts' => $assetsOnObjectStorage
            ? $objectStorageDisk('fonts')
            : [
                'driver' => 'local',
                'root' => public_path('fonts'),
                'url' => env('APP_URL').'/fonts',
                'visibility' => 'public',
            ],
    ],

];
