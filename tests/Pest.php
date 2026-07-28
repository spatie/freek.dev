<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

pest()->printer()->compact();

uses(TestCase::class, RefreshDatabase::class)
    ->beforeEach(function () {
        ray()->newScreen($this->name());
        Bus::fake();
    })
    ->in(__DIR__);
