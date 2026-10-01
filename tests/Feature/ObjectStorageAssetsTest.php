<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

function bootWithAssetsOnObjectStorage(): void
{
    putenv('ASSETS_ON_OBJECT_STORAGE=true');
    putenv('OBJECT_STORAGE_BUCKET=freek-dev-assets');

    test()->refreshApplication();
}

afterEach(function () {
    putenv('ASSETS_ON_OBJECT_STORAGE');
    putenv('OBJECT_STORAGE_BUCKET');
});

it('keeps assets on local disks by default', function () {
    expect(config('filesystems.disks.public.driver'))->toBe('local')
        ->and(config('filesystems.disks.public.root'))->toBe(storage_path('app/public'))
        ->and(config('filesystems.disks.admin-uploads.driver'))->toBe('local')
        ->and(config('filesystems.disks.admin-uploads.root'))->toBe(storage_path('admin-uploads'))
        ->and(config('filesystems.disks.avatars.driver'))->toBe('local')
        ->and(config('filesystems.disks.avatars.root'))->toBe(storage_path('avatars'))
        ->and(Route::has('objectStorageAsset'))->toBeFalse();
});

it('stores assets on object storage in a directory matching their url segment', function (string $diskName, string $directory) {
    bootWithAssetsOnObjectStorage();

    expect(config("filesystems.disks.{$diskName}.driver"))->toBe('s3')
        ->and(config("filesystems.disks.{$diskName}.root"))->toBe($directory)
        ->and(Storage::disk($diskName)->url('file.png'))->toBe(config('app.url')."/{$directory}/file.png");
})->with([
    ['uploads', 'uploads'],
    ['admin-uploads', 'admin-uploads'],
    ['avatars', 'avatars'],
    ['fonts', 'fonts'],
    ['public', 'storage'],
]);

it('serves assets from object storage under their public url', function (string $segment, string $diskName) {
    bootWithAssetsOnObjectStorage();

    Storage::fake($diskName);
    Storage::disk($diskName)->put('2024/01/image.png', 'image-contents');

    $response = $this->get("{$segment}/2024/01/image.png")
        ->assertOk()
        ->assertHeader('Cache-Control', 'max-age=2592000, public');

    expect($response->streamedContent())->toBe('image-contents');
})->with([
    ['uploads', 'uploads'],
    ['admin-uploads', 'admin-uploads'],
    ['avatars', 'avatars'],
    ['fonts', 'fonts'],
    ['storage', 'public'],
]);

it('returns a 404 for assets that do not exist on object storage', function () {
    bootWithAssetsOnObjectStorage();

    Storage::fake('uploads');

    $this->get('uploads/does-not-exist.png')->assertNotFound();
});

it('does not serve paths that try to leave the disk', function () {
    bootWithAssetsOnObjectStorage();

    Storage::fake('uploads');

    $this->get('uploads/../.env')->assertNotFound();
});

it('streams og images from object storage instead of redirecting to the bucket', function () {
    bootWithAssetsOnObjectStorage();

    Storage::fake('public');
    Storage::disk('public')->put('og-images/abc123.jpeg', 'og-image-contents');

    $this->get('og-image/abc123.jpeg')
        ->assertOk()
        ->assertHeader('Content-Type', 'image/jpeg')
        ->assertContent('og-image-contents');
});
