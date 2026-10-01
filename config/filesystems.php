<?php

/*
 * When assets live on object storage, every disk is scoped to the directory matching its public URL
 * segment and generates freek.dev URLs. Those URLs are served by ServeObjectStorageAssetController,
 * so content never contains URLs that point to the storage backend.
 *
 * The credentials don't use the AWS_* variables, because the AWS SDK picks those up globally,
 * which would also apply them to Laravel Cloud's managed queues.
 */
$objectStorageDisk = fn (string $directory): array => [
    'driver' => 's3',
    'key' => env('OBJECT_STORAGE_ACCESS_KEY_ID'),
    'secret' => env('OBJECT_STORAGE_SECRET_ACCESS_KEY'),
    'region' => env('OBJECT_STORAGE_REGION', 'auto'),
    'bucket' => env('OBJECT_STORAGE_BUCKET'),
    'endpoint' => env('OBJECT_STORAGE_ENDPOINT'),
    'use_path_style_endpoint' => false,
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
