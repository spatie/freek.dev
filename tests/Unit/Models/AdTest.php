<?php

use App\Models\Ad;
use Carbon\Carbon;
use function Spatie\PestPluginTestTime\testTime;

it('can get an ad for the current date', function () {
    $januaryAd = createAdForYearMonth(2018, 1);

    $februaryAd = createAdForYearMonth(2018, 2);

    testTime()->freeze('2017-12-31 00:00:00');
    expect(Ad::getForPage())->toBeNull();

    testTime()->freeze('2018-01-01 01:00:00');
    expect(Ad::getForPage()->id)->toEqual($januaryAd->id);

    testTime()->freeze('2018-01-15 00:00:00');
    expect(Ad::getForPage()->id)->toEqual($januaryAd->id);

    testTime()->freeze('2018-01-31 00:00:00');
    expect(Ad::getForPage()->id)->toEqual($januaryAd->id);

    testTime()->freeze('2018-02-01 00:00:00');
    expect(Ad::getForPage()->id)->toEqual($februaryAd->id);

    testTime()->freeze('2018-02-15 00:00:00');
    expect(Ad::getForPage()->id)->toEqual($februaryAd->id);

    testTime()->freeze('2018-02-28 00:00:00');
    expect(Ad::getForPage()->id)->toEqual($februaryAd->id);

    testTime()->freeze('2018-03-01 00:00:00');
    expect(Ad::getForPage())->toBeNull();
});

test('an url specific ad will be displayed on that url', function () {
    testTime()->freeze('2018-01-01 00:00:00');

    $ad = createAdForYearMonth(2018, 1, ['display_on_url' => 'test-url']);

    expect(Ad::getForPage())->toBeNull();

    expect(Ad::getForPage('test-url')->id)->toEqual($ad->id);
});

test('a url specific ad takes precedence over the site wide one', function () {
    testTime()->freeze('2018-01-01 00:00:00');

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
