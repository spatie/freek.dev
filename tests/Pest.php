<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Bus;
use Tests\CreatesApplication;

uses(TestCase::class, CreatesApplication::class, RefreshDatabase::class)
    ->beforeEach(function () {
        ray()->newScreen($this->name());
        Bus::fake();
    })
    ->in(__DIR__);
