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
        $this->assertNull(Ad::getForCurrentUrl());

        $this->setNow(2018, 1, 1);
        $this->assertEquals($januaryAd->id, Ad::getForCurrentUrl()->id);

        $this->setNow(2018, 1, 15);
        $this->assertEquals($januaryAd->id, Ad::getForCurrentUrl()->id);

        $this->setNow(2018, 1, 31);
        $this->assertEquals($januaryAd->id, Ad::getForCurrentUrl()->id);

        $this->setNow(2018, 2, 1);
        $this->assertEquals($februaryAd->id, Ad::getForCurrentUrl()->id);

        $this->setNow(2018, 2, 15);
        $this->assertEquals($februaryAd->id, Ad::getForCurrentUrl()->id);

        $this->setNow(2018, 2, 28);
        $this->assertEquals($februaryAd->id, Ad::getForCurrentUrl()->id);

        $this->setNow(2018, 3, 1);
        $this->assertNull(Ad::getForCurrentUrl());
    }

    protected function createAdForYearMonth(int $year, int $month, array $attributes = []): Ad
    {
        $startsAt = Carbon::createFromDate($year, $month);
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
