<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

function bootWithAssetsOnObjectStorage(?string $objectStorageUrl = null): void
{
    putenv('ASSETS_ON_OBJECT_STORAGE=true');
    putenv('OBJECT_STORAGE_BUCKET=freek-dev-assets');

    if ($objectStorageUrl) {
        putenv("OBJECT_STORAGE_URL={$objectStorageUrl}");
    }

    test()->refreshApplication();
}

afterEach(function () {
    putenv('ASSETS_ON_OBJECT_STORAGE');
    putenv('OBJECT_STORAGE_BUCKET');
    putenv('OBJECT_STORAGE_URL');
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

it('ignores the object storage url when assets are not on object storage', function () {
    putenv('OBJECT_STORAGE_URL=https://bucket.test');

    $this->refreshApplication();

    expect(config('filesystems.object_storage_url'))->toBeNull()
        ->and(Storage::disk('admin-uploads')->url('file.png'))->toBe(config('app.url').'/admin-uploads/file.png');
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

it('generates urls on the public bucket when an object storage url is set', function (string $diskName, string $directory) {
    bootWithAssetsOnObjectStorage('https://bucket.test');

    expect(Storage::disk($diskName)->url('file.png'))->toBe("https://bucket.test/{$directory}/file.png");
})->with([
    ['uploads', 'uploads'],
    ['admin-uploads', 'admin-uploads'],
    ['avatars', 'avatars'],
    ['public', 'storage'],
]);

it('keeps generating freek.dev urls for fonts when an object storage url is set', function () {
    bootWithAssetsOnObjectStorage('https://bucket.test');

    expect(Storage::disk('fonts')->url('font.woff2'))->toBe(config('app.url').'/fonts/font.woff2');
});

it('stores new assets on object storage with a long cache lifetime', function (string $diskName) {
    bootWithAssetsOnObjectStorage();

    expect(config("filesystems.disks.{$diskName}.options.CacheControl"))->toBe('public, max-age=31536000, immutable');
})->with(['uploads', 'admin-uploads', 'avatars', 'fonts', 'public']);

it('redirects old asset urls to the public bucket', function (string $segment) {
    bootWithAssetsOnObjectStorage('https://bucket.test');

    $this->get("{$segment}/2024/01/image.png")
        ->assertStatus(301)
        ->assertRedirect("https://bucket.test/{$segment}/2024/01/image.png")
        ->assertHeader('Cache-Control', 'max-age=2592000, public');
})->with(['uploads', 'admin-uploads', 'avatars', 'storage']);

it('encodes the path when redirecting to the public bucket', function () {
    bootWithAssetsOnObjectStorage('https://bucket.test');

    $this->get('uploads/2024/my%20image.png')
        ->assertRedirect('https://bucket.test/uploads/2024/my%20image.png');
});

it('keeps streaming fonts when an object storage url is set', function () {
    bootWithAssetsOnObjectStorage('https://bucket.test');

    Storage::fake('fonts');
    Storage::disk('fonts')->put('884760/font.woff2', 'font-contents');

    $response = $this->get('fonts/884760/font.woff2')->assertOk();

    expect($response->streamedContent())->toBe('font-contents');
});

it('returns a 404 for a font directory instead of a file', function () {
    bootWithAssetsOnObjectStorage('https://bucket.test');

    Storage::fake('fonts');
    Storage::disk('fonts')->put('884760/font.woff2', 'font-contents');

    $this->get('fonts/884760')->assertNotFound();
});

it('does not redirect paths that try to leave the disk', function () {
    bootWithAssetsOnObjectStorage('https://bucket.test');

    $this->get('uploads/../.env')->assertNotFound();
});

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
    bootWithAssetsOnObjectStorage('https://bucket.test');

    Storage::fake('public');
    Storage::disk('public')->put('og-images/abc123.jpeg', 'og-image-contents');

    $this->get('og-image/abc123.jpeg')
        ->assertOk()
        ->assertHeader('Content-Type', 'image/jpeg')
        ->assertContent('og-image-contents');
});
