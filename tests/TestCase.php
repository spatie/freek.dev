<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use RefreshDatabase;

    protected function setNow(...$dateTimeParts): Carbon
    {
        $now = Carbon::create(...$dateTimeParts);

        Carbon::setTestNow($now);

        return $now->copy();
    }
}
