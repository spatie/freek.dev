<?php

use App\Models\Ad;
use Carbon\Carbon;
use Tests\TestCase;

uses(TestCase::class);

it('can get an ad for the current date', function () {
    $januaryAd = createAdForYearMonth(2018, 1);

    $februaryAd = createAdForYearMonth(2018, 2);

    $this->setNow(2017, 12, 31);
    $this->assertNull(Ad::getForPage());

    $this->setNow(2018, 1, 1, 1, 0, 0);

    $this->assertEquals($januaryAd->id, Ad::getForPage()->id);

    $this->setNow(2018, 1, 15, 0, 0, 0);
    $this->assertEquals($januaryAd->id, Ad::getForPage()->id);

    $this->setNow(2018, 1, 31, 0, 0, 0);
    $this->assertEquals($januaryAd->id, Ad::getForPage()->id);

    $this->setNow(2018, 2, 1, 0, 0, 0);
    $this->assertEquals($februaryAd->id, Ad::getForPage()->id);

    $this->setNow(2018, 2, 15, 0, 0, 0);
    $this->assertEquals($februaryAd->id, Ad::getForPage()->id);

    $this->setNow(2018, 2, 28, 0, 0, 0);
    $this->assertEquals($februaryAd->id, Ad::getForPage()->id);

    $this->setNow(2018, 3, 1, 0, 0, 0);
    $this->assertNull(Ad::getForPage());
});

test('an url specific ad will be displayed on that url', function () {
    $this->setNow(2018, 1, 1);

    $ad = createAdForYearMonth(2018, 1, ['display_on_url' => 'test-url']);

    $this->assertNull(Ad::getForPage());

    $this->assertEquals($ad->id, Ad::getForPage('test-url')->id);
});

test('a url specific ad takes precedence over the site wide one', function () {
    $this->setNow(2018, 1, 1, 0, 0, 0);

    $urlSpecificAd = createAdForYearMonth(2018, 1, ['display_on_url' => 'test-url']);

    $siteWideAd = createAdForYearMonth(2018, 1);

    $this->assertEquals($urlSpecificAd->id, Ad::getForPage('test-url')->id);

    $this->assertEquals($siteWideAd->id, Ad::getForPage('another-url')->id);
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
