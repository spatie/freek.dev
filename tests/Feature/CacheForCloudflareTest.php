<?php

beforeEach(function () {
    config(['cache.cloudflare_enabled' => true]);
});

it('does not set cookies for guest GET requests on public pages', function () {
    $response = $this->get('/');

    $response->assertOk();
    expect($response->headers->getCookies())->toBeEmpty();
});

it('keeps cookies when user has existing session', function () {
    $response = $this->withCookie(config('session.cookie'), 'existing')
        ->get('/');

    $response->assertOk();
    expect($response->headers->getCookies())->not->toBeEmpty();
});

it('keeps cookies on auth-protected routes', function () {
    // This route requires auth, so it redirects to login
    $response = $this->get('/community/link/create');

    $response->assertRedirect();

    // Should have cookies for the redirect/auth flow
    expect($response->headers->getCookies())->not->toBeEmpty();
});
