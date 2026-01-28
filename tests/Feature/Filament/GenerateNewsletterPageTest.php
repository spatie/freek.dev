<?php

use App\Filament\Pages\GenerateNewsletter;
use App\Models\User;
use Livewire\Livewire;
use Spatie\MailcoachSdk\Facades\Mailcoach;
use Spatie\MailcoachSdk\Resources\Campaign;
use Spatie\MailcoachSdk\Support\PaginatedResults;

beforeEach(function () {
    if (! config('mailcoach-sdk.api_token')) {
        $this->markTestSkipped('Mailcoach API token not configured');
    }

    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    $this->existingCampaign = new Campaign([
        'uuid' => 'existing-campaign-uuid',
        'name' => 'freek.dev newsletter #100',
        'createdAt' => now()->subDays(7)->toIso8601String(),
    ]);

    $this->newCampaign = new Campaign([
        'uuid' => 'new-campaign-uuid',
        'name' => 'freek.dev newsletter #101',
        'createdAt' => now()->toIso8601String(),
    ]);
});

test('the page can be rendered', function () {
    Livewire::test(GenerateNewsletter::class)
        ->assertSuccessful();
});

test('the generate action creates a newsletter', function () {
    $paginatedResults = Mockery::mock(PaginatedResults::class);
    $paginatedResults->shouldReceive('getIterator')
        ->andReturn(new ArrayIterator([$this->existingCampaign]));

    Mailcoach::shouldReceive('campaigns')
        ->once()
        ->andReturn($paginatedResults);

    Mailcoach::shouldReceive('createCampaign')
        ->once()
        ->andReturn($this->newCampaign);

    Livewire::test(GenerateNewsletter::class)
        ->callAction('generate')
        ->assertNotified('Newsletter #101 created');
});

test('the generate action shows error notification on failure', function () {
    Mailcoach::shouldReceive('campaigns')
        ->once()
        ->andThrow(new Exception('Could not find a freek.dev campaign'));

    Livewire::test(GenerateNewsletter::class)
        ->callAction('generate')
        ->assertNotified('Failed to generate newsletter');
});
