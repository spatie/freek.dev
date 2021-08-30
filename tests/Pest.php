<?php

use \Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\TestCase;

uses(TestCase::class, CreatesApplication::class, RefreshDatabase::class)
    ->beforeEach(function() {
        ray()->newScreen($this->getName());
    })
    ->in(__DIR__);
