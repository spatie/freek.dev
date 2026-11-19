<?php

use App\Models\User;
use Filament\Auth\Pages\Login;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\SuspiciousLogin\Enums\RiskLevel;
use Spatie\SuspiciousLogin\Mail\SuspiciousLoginMail;
use Spatie\SuspiciousLogin\Models\LoginAttempt;

beforeEach(function () {
    Mail::fake();
    Http::preventStrayRequests();
    config(['cache.cloudflare_enabled' => true]);
});

it('recognizes returning browsers and notifies about suspicious community logins without blocking', function () {
    Http::fake([
        'ipinfo.io/81.82.83.84/json' => Http::response(['country' => 'BE', 'city' => 'Antwerp', 'loc' => '51.2194,4.4025']),
        'ipinfo.io/93.184.216.34/json' => Http::response(['country' => 'US', 'city' => 'New York', 'loc' => '40.7128,-74.0060']),
    ]);

    $user = User::factory()->create();
    $credentials = ['email' => $user->email, 'password' => 'secret'];

    $response = $this->withServerVariables(['REMOTE_ADDR' => '81.82.83.84'])
        ->withHeaders(['User-Agent' => 'Mozilla/5.0 Chrome/141.0 Safari/537.36'])
        ->post('/login', $credentials)
        ->assertRedirect('/community')
        ->assertCookie('suspicious_login_device');

    $firstAttempt = LoginAttempt::sole();

    expect($firstAttempt->authenticatable->is($user))->toBeTrue()
        ->and($firstAttempt->risk_score)->toBe(0);

    $this->post('/logout');
    $this->withCookie('suspicious_login_device', $response->getCookie('suspicious_login_device')->getValue())
        ->withHeaders(['User-Agent' => 'Mozilla/5.0 Chrome/142.0 Safari/537.36'])
        ->post('/login', $credentials)
        ->assertRedirect('/community');

    expect(LoginAttempt::query()->latest('id')->first()->device_fingerprint)->toBe($firstAttempt->device_fingerprint)
        ->and(LoginAttempt::query()->latest('id')->first()->risk_score)->toBe(0);

    Mail::assertNothingOutgoing();

    $this->post('/logout');
    $this->travel(30)->minutes();

    $this->withCookie('suspicious_login_device', '')
        ->withServerVariables(['REMOTE_ADDR' => '93.184.216.34'])
        ->post('/login', $credentials)
        ->assertRedirect('/community')
        ->assertCookie('suspicious_login_device');

    $attempt = LoginAttempt::query()->latest('id')->first();

    expect($attempt->risk_level)->toBe(RiskLevel::High)
        ->and($attempt->blocked)->toBeFalse()
        ->and($attempt->device_fingerprint)->not->toBe($firstAttempt->device_fingerprint)
        ->and($attempt->country_code)->toBe('US');

    $this->assertAuthenticatedAs($user);

    Mail::assertQueued(SuspiciousLoginMail::class, fn (SuspiciousLoginMail $mail) => $mail->hasTo($user->email) && $mail->loginAttempt->is($attempt));
    Mail::assertQueuedCount(1);
});

it('records admin panel logins', function () {
    $user = User::factory()->admin()->create(['email' => 'freek@spatie.be']);

    Livewire::test(Login::class)
        ->fillForm(['email' => $user->email, 'password' => 'secret'])
        ->call('authenticate')
        ->assertHasNoFormErrors()
        ->assertRedirect();

    $attempt = LoginAttempt::sole();

    expect($attempt->authenticatable->is($user))->toBeTrue()
        ->and($attempt->successful)->toBeTrue()
        ->and($attempt->device_fingerprint)->not->toBeNull();

    $this->assertAuthenticatedAs($user);

    Mail::assertNothingOutgoing();
});

it('records failed logins without exposing passwords or sending alerts', function () {
    $user = User::factory()->create();

    $this->post('/login', ['email' => $user->email, 'password' => 'incorrect-password'])
        ->assertSessionHasErrors('email');

    $attempt = LoginAttempt::sole();

    expect($attempt->successful)->toBeFalse()
        ->and($attempt->identifier)->toBe($user->email)
        ->and($attempt->risk_score)->toBeNull()
        ->and($attempt->toJson())->not->toContain('incorrect-password');

    $this->assertGuest();

    Mail::assertNothingOutgoing();
});
