<?php

use App\Livewire\CustomCardComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(CustomCardComponent::class)
        ->assertStatus(200);
});
