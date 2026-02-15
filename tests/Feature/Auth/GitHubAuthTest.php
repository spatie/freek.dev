<?php

use App\Models\Commenter;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\get;

it('redirects to GitHub for authorization', function () {
    get('/auth/github')
        ->assertRedirect()
        ->assertRedirectContains('github.com/login/oauth/authorize');
});

it('handles the callback and creates a commenter', function () {
    Http::fake([
        'github.com/login/oauth/access_token' => Http::response([
            'access_token' => 'fake-github-token',
        ]),
        'api.github.com/user' => Http::response([
            'id' => 12345,
            'login' => 'testuser',
            'name' => 'Test User',
            'avatar_url' => 'https://avatars.githubusercontent.com/u/12345',
        ]),
    ]);

    session()->put('github_oauth_state', 'test-state');

    get('/auth/github/callback?code=test-code&state=test-state')
        ->assertOk()
        ->assertViewIs('auth.github-callback');

    expect(Commenter::where('github_id', 12345)->exists())->toBeTrue();

    $commenter = Commenter::where('github_id', 12345)->first();
    expect($commenter->username)->toBe('testuser');
    expect($commenter->name)->toBe('Test User');
});

it('updates existing commenter on repeated login', function () {
    Commenter::factory()->create([
        'github_id' => 12345,
        'username' => 'oldname',
        'name' => 'Old Name',
    ]);

    Http::fake([
        'github.com/login/oauth/access_token' => Http::response([
            'access_token' => 'fake-github-token',
        ]),
        'api.github.com/user' => Http::response([
            'id' => 12345,
            'login' => 'newname',
            'name' => 'New Name',
            'avatar_url' => 'https://avatars.githubusercontent.com/u/12345',
        ]),
    ]);

    session()->put('github_oauth_state', 'test-state');

    get('/auth/github/callback?code=test-code&state=test-state')
        ->assertOk();

    expect(Commenter::where('github_id', 12345)->count())->toBe(1);
    expect(Commenter::where('github_id', 12345)->first()->username)->toBe('newname');
});

it('rejects callback with invalid state', function () {
    session()->put('github_oauth_state', 'correct-state');

    get('/auth/github/callback?code=test-code&state=wrong-state')
        ->assertForbidden();
});
