<?php

use App\Models\Ad;
use Carbon\Carbon;
use Tests\TestCase;

uses(TestCase::class);

it('can get an ad for the current date', function () {
    $januaryAd = createAdForYearMonth(2018, 1);

    $februaryAd = createAdForYearMonth(2018, 2);

    $this->setNow(2017, 12, 31);
    expect(Ad::getForPage())->toBeNull();

    $this->setNow(2018, 1, 1, 1, 0, 0);

    expect(Ad::getForPage()->id)->toEqual($januaryAd->id);

    $this->setNow(2018, 1, 15, 0, 0, 0);
    expect(Ad::getForPage()->id)->toEqual($januaryAd->id);

    $this->setNow(2018, 1, 31, 0, 0, 0);
    expect(Ad::getForPage()->id)->toEqual($januaryAd->id);

    $this->setNow(2018, 2, 1, 0, 0, 0);
    expect(Ad::getForPage()->id)->toEqual($februaryAd->id);

    $this->setNow(2018, 2, 15, 0, 0, 0);
    expect(Ad::getForPage()->id)->toEqual($februaryAd->id);

    $this->setNow(2018, 2, 28, 0, 0, 0);
    expect(Ad::getForPage()->id)->toEqual($februaryAd->id);

    $this->setNow(2018, 3, 1, 0, 0, 0);
    expect(Ad::getForPage())->toBeNull();
});

test('an url specific ad will be displayed on that url', function () {
    $this->setNow(2018, 1, 1);

    $ad = createAdForYearMonth(2018, 1, ['display_on_url' => 'test-url']);

    expect(Ad::getForPage())->toBeNull();

    expect(Ad::getForPage('test-url')->id)->toEqual($ad->id);
});

test('a url specific ad takes precedence over the site wide one', function () {
    $this->setNow(2018, 1, 1, 0, 0, 0);

    $urlSpecificAd = createAdForYearMonth(2018, 1, ['display_on_url' => 'test-url']);

    $siteWideAd = createAdForYearMonth(2018, 1);

    expect(Ad::getForPage('test-url')->id)->toEqual($urlSpecificAd->id);

    expect(Ad::getForPage('another-url')->id)->toEqual($siteWideAd->id);
});

// Helpers
function createAdForYearMonth(int $year, int $month, array $attributes = []): Ad
{
    $startsAt = Carbon::createFromDate($year, $month, 1)->startOfMonth();
    $endsAt = $startsAt->copy()->endOfMonth();

    $defaultAttributes = [
        'display_on_url' => null,
        'starts_at' => $startsAt->format('Y-m-d'),
        'ends_at' => $endsAt->format('Y-m-d'),
    ];

    $attributes = array_merge($defaultAttributes, $attributes);

    return Ad::factory()->create($attributes);
}
