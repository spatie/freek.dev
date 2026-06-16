<?php


use function Pure\expect;
use function Pure\it;
use function Pure\test;
use function Pure\beforeEach;
use function Pure\afterEach;
it('can render the main feed', function () {
    $this->get('/feed')->assertOk();
});

it('can render the php feed', function () {
    $this->get('/feed/php')->assertOk();
});

it('can render the originals feed', function () {
    $this->get('/feed/originals')->assertOk();
});
