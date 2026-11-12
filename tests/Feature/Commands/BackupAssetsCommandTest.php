<?php

use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('object-storage');
    Storage::fake('backups');
});

it('copies assets that are not backed up yet', function () {
    Storage::disk('object-storage')->put('uploads/2024/image.png', 'image');
    Storage::disk('object-storage')->put('avatars/1/avatar.jpg', 'avatar');

    $this->artisan('app:backup-assets')
        ->expectsOutput('Copied 2 files, 0 failed.')
        ->assertSuccessful();

    expect(Storage::disk('backups')->get('assets/uploads/2024/image.png'))->toBe('image')
        ->and(Storage::disk('backups')->get('assets/avatars/1/avatar.jpg'))->toBe('avatar');
});

it('copies assets that changed since the last backup', function () {
    Storage::disk('object-storage')->put('uploads/image.png', 'new contents');
    Storage::disk('backups')->put('assets/uploads/image.png', 'old');

    $this->artisan('app:backup-assets')->assertSuccessful();

    expect(Storage::disk('backups')->get('assets/uploads/image.png'))->toBe('new contents');
});

it('skips assets that are already backed up', function () {
    Storage::disk('object-storage')->put('uploads/image.png', 'image');
    Storage::disk('backups')->put('assets/uploads/image.png', 'image');

    $this->artisan('app:backup-assets')
        ->expectsOutput('Copying 0 files...')
        ->assertSuccessful();
});

it('never deletes backed up assets that were removed from object storage', function () {
    Storage::disk('backups')->put('assets/uploads/deleted.png', 'image');

    $this->artisan('app:backup-assets')->assertSuccessful();

    expect(Storage::disk('backups')->exists('assets/uploads/deleted.png'))->toBeTrue();
});
