<?php

/*
 * When assets live on object storage, every disk is scoped to the directory matching its public URL
 * segment. When OBJECT_STORAGE_URL is set, disks generate URLs on the public bucket and old freek.dev
 * asset URLs are redirected there by ServeObjectStorageAssetController. Without it, the controller
 * streams the assets and disks generate freek.dev URLs.
 *
 * Asset filenames are unique, so browsers and CDNs may cache them forever.
 *
 * The credentials don't use the AWS_* variables, because the AWS SDK picks those up globally,
 * which would also apply them to Laravel Cloud's managed queues.
 */
$objectStorageUrl = env('OBJECT_STORAGE_URL');

$objectStorageDisk = fn (string $directory): array => [
    'driver' => 's3',
    'key' => env('OBJECT_STORAGE_ACCESS_KEY_ID'),
    'secret' => env('OBJECT_STORAGE_SECRET_ACCESS_KEY'),
    'region' => env('OBJECT_STORAGE_REGION', 'auto'),
    'bucket' => env('OBJECT_STORAGE_BUCKET'),
    'endpoint' => env('OBJECT_STORAGE_ENDPOINT'),
    'use_path_style_endpoint' => false,
    'root' => $directory,
    'url' => $objectStorageUrl ?: env('APP_URL'),
    'options' => [
        'CacheControl' => 'public, max-age=31536000, immutable',
    ],
    'throw' => false,
    'report' => false,
];

$assetsOnObjectStorage = (bool) env('ASSETS_ON_OBJECT_STORAGE', false);

return [

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    'assets_on_object_storage' => $assetsOnObjectStorage,

    'object_storage_url' => $assetsOnObjectStorage ? $objectStorageUrl : null,

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

        'object-storage' => $objectStorageDisk(''),

        'backups' => [
            'driver' => 's3',
            'key' => env('BACKUP_STORAGE_ACCESS_KEY_ID'),
            'secret' => env('BACKUP_STORAGE_SECRET_ACCESS_KEY'),
            'region' => env('BACKUP_STORAGE_REGION', 'auto'),
            'bucket' => env('BACKUP_STORAGE_BUCKET'),
            'endpoint' => env('BACKUP_STORAGE_ENDPOINT'),
            'use_path_style_endpoint' => false,
            'throw' => true,
        ],

        /*
         * Fonts keep freek.dev URLs, because the Hoefler stylesheet loads them from there and
         * loading fonts from another origin would require CORS.
         */
        'fonts' => $assetsOnObjectStorage
            ? [...$objectStorageDisk('fonts'), 'url' => env('APP_URL')]
            : [
                'driver' => 'local',
                'root' => public_path('fonts'),
                'url' => env('APP_URL').'/fonts',
                'visibility' => 'public',
            ],
    ],

];
