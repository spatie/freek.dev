<?php

use function Pest\Laravel\get;

it('displays the music page', function () {
    get('/music')
        ->assertOk()
        ->assertSee('Beach Architecture');
});

it('loads release artwork from the uploads disk', function () {
    config()->set('filesystems.disks.uploads.url', 'https://bucket.test/uploads');

    get('/music')
        ->assertOk()
        ->assertSee('https://bucket.test/uploads/media/music/beach-architecture.jpg', escape: false)
        ->assertDontSee('https://freek.dev/uploads/media/music', escape: false);
});
