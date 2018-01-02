<?php

namespace Tests\Unit\Models;

use App\Models\Ad;
use Carbon\Carbon;
use Tests\TestCase;

class AdTest extends TestCase
{
    /** @test */
    public function it_can_get_an_ad_for_the_current_date()
    {
        $januaryAd = $this->createAdForYearMonth(2018, 1);

        $februaryAd = $this->createAdForYearMonth(2018, 2);

        $this->setNow(2017, 12, 31);
        $this->assertNull(Ad::getForPage());

        $this->setNow(2018, 1, 1);

        $this->assertEquals($januaryAd->id, Ad::getForPage()->id);

        $this->setNow(2018, 1, 15);
        $this->assertEquals($januaryAd->id, Ad::getForPage()->id);

        $this->setNow(2018, 1, 31);
        $this->assertEquals($januaryAd->id, Ad::getForPage()->id);

        $this->setNow(2018, 2, 1);
        $this->assertEquals($februaryAd->id, Ad::getForPage()->id);

        $this->setNow(2018, 2, 15);
        $this->assertEquals($februaryAd->id, Ad::getForPage()->id);

        $this->setNow(2018, 2, 28);
        $this->assertEquals($februaryAd->id, Ad::getForPage()->id);

        $this->setNow(2018, 3, 1);
        $this->assertNull(Ad::getForPage());
    }

    /** @test */
    public function a_url_specific_ad_will_be_displayed_on_that_url()
    {
        $ad = $this->createAdForYearMonth(2018, 1, ['display_on_url' => 'test-url']);

        $this->assertNull(Ad::getForPage());

        $this->assertEquals($ad->id, Ad::getForPage('test-url')->id);
    }

    /** @test */
    public function a_url_specific_ad_takes_precedence_over_the_site_wide_one()
    {
        $urlSpecificAd = $this->createAdForYearMonth(2018, 1, ['display_on_url' => 'test-url']);

        $siteWideAd = $this->createAdForYearMonth(2018, 1);

        $this->assertEquals($urlSpecificAd->id, Ad::getForPage('test-url')->id);

        $this->assertEquals($siteWideAd->id, Ad::getForPage('another-url')->id);
    }

    protected function createAdForYearMonth(int $year, int $month, array $attributes = []): Ad
    {
        $startsAt = Carbon::createFromDate($year, $month, 1);
        $endsAt = $startsAt->copy()->endOfMonth();

        $defaultAttributes = [
            'display_on_url' => '',
            'starts_at' => $startsAt->format('Y-m-d'),
            'ends_at' => $endsAt->format('Y-m-d'),
        ];

        $attributes = array_merge($defaultAttributes, $attributes);

        return factory(Ad::class)->create($attributes);
    }
}
