<?php

use App\Jobs\PurgeCloudflareCacheJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Schedule as ScheduleFacade;

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

it('lets the edge cache guest pages longer than browsers', function () {
    $this->get('/')
        ->assertOk()
        ->assertHeader('Cache-Control', 'max-age=60, public, s-maxage=86400');
});

it('does not cache the community page at the edge because it shows who is logged in', function () {
    $response = $this->get('/community');

    $response->assertOk();
    expect($response->headers->get('Cache-Control'))->not->toContain('public');
});

it('hides the edit link on posts for guests', function () {
    $post = Post::factory()->create(['published' => true, 'publish_date' => now()->subDay()]);

    $this->get($post->url)
        ->assertOk()
        ->assertSee('<span data-admin-only hidden>', false);
});

it('shows the edit link on posts for admins', function () {
    $post = Post::factory()->create(['published' => true, 'publish_date' => now()->subDay()]);

    $this->actingAs(User::factory()->admin()->create())
        ->get($post->url)
        ->assertOk()
        ->assertSee("/admin/posts/{$post->id}/edit", false)
        ->assertDontSee('data-admin-only hidden', false);
});

it('remembers admins in their browser when they log in', function () {
    $admin = User::factory()->admin()->create();

    $this->post('/login', ['email' => $admin->email, 'password' => 'secret'])
        ->assertCookie('admin', '1')
        ->assertCookieNotExpired('admin');
});

it('does not remember regular users as admins when they log in', function () {
    $user = User::factory()->create();

    $this->post('/login', ['email' => $user->email, 'password' => 'secret'])
        ->assertCookieMissing('admin');
});

it('forgets the admin when logging out', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->post('/logout')
        ->assertCookieExpired('admin');
});

it('purges the edge every day after clearing the response cache', function () {
    ScheduleFacade::swap(new Schedule);

    require base_path('routes/console.php');

    $responseCacheClear = collect(ScheduleFacade::events())
        ->first(fn (Event $event) => str_contains((string) $event->command, 'responsecache:clear'));

    expect($responseCacheClear->expression)->toBe('0 0 * * *');

    $responseCacheClear->callAfterCallbacks(app());

    Bus::assertDispatched(PurgeCloudflareCacheJob::class);
});
