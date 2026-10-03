<?php

use function Pest\Laravel\get;

it('serves resized webp images on pages', function (string $uri, int $status, string $image) {
    get($uri)
        ->assertStatus($status)
        ->assertSee(url("images/{$image}"), false);

    expect(public_path("images/{$image}"))->toBeFile();
})->with([
    'bio avatar' => ['/', 200, 'avatar.webp'],
    'about avatar' => ['/about', 200, 'avatar-boxed.webp'],
    'error image' => ['/this-page-does-not-exist', 404, '404.webp'],
]);
