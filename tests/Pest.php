<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

uses(TestCase::class, CreatesApplication::class, RefreshDatabase::class)
    ->beforeEach(function () {
        ray()->newScreen($this->getName());
        \Illuminate\Support\Facades\Bus::fake();
    })
    ->in(__DIR__);
