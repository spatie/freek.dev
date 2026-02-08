<?php

it('can render the main feed', function () {
    $this->get('/feed')->assertOk();
});

it('can render the php feed', function () {
    $this->get('/feed/php')->assertOk();
});

it('can render the originals feed', function () {
    $this->get('/feed/originals')->assertOk();
});
