<?php

use App\Actions\GenerateNewsletterAction;
use App\Actions\GenerateNewsletterResult;
use Spatie\MailcoachSdk\Facades\Mailcoach;
use Spatie\MailcoachSdk\Resources\Campaign;
use Spatie\MailcoachSdk\Support\PaginatedResults;

beforeEach(function () {
    if (! config('mailcoach-sdk.api_token')) {
        $this->markTestSkipped('Mailcoach API token not configured');
    }

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

test('it generates a newsletter and returns the result', function () {
    $paginatedResults = Mockery::mock(PaginatedResults::class);
    $paginatedResults->shouldReceive('getIterator')
        ->andReturn(new ArrayIterator([$this->existingCampaign]));

    Mailcoach::shouldReceive('campaigns')
        ->once()
        ->andReturn($paginatedResults);

    Mailcoach::shouldReceive('createCampaign')
        ->once()
        ->withArgs(function (array $data) {
            expect($data['name'])->toBe('freek.dev newsletter #101');
            expect($data['subject'])->toBe('freek.dev newsletter #101');

            return true;
        })
        ->andReturn($this->newCampaign);

    $action = new GenerateNewsletterAction;
    $result = $action->execute();

    expect($result)->toBeInstanceOf(GenerateNewsletterResult::class);
    expect($result->editionNumber)->toBe(101);
    expect($result->campaign->uuid)->toBe('new-campaign-uuid');
});

test('the result can generate the mailcoach url', function () {
    config(['mailcoach-sdk.endpoint' => 'https://mailcoach.example.com/api']);

    $result = new GenerateNewsletterResult(
        campaign: $this->newCampaign,
        editionNumber: 101,
        startDate: now()->subDays(7),
        endDate: now(),
    );

    expect($result->getMailcoachUrl())->toBe('https://mailcoach.example.com/api/campaigns/new-campaign-uuid');
});

test('the mailcoach url trims trailing slashes from endpoint', function () {
    config(['mailcoach-sdk.endpoint' => 'https://mailcoach.example.com/api/']);

    $result = new GenerateNewsletterResult(
        campaign: $this->newCampaign,
        editionNumber: 101,
        startDate: now()->subDays(7),
        endDate: now(),
    );

    expect($result->getMailcoachUrl())->toBe('https://mailcoach.example.com/api/campaigns/new-campaign-uuid');
});
