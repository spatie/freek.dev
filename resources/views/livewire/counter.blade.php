<?php

use function Livewire\Volt\{state};

state(['count' => 0]);

$increment = fn () => $this->count++;

?>

<div>
    This is my counter {{ $this->count }}

    <button wire:click="increment">+</button>
</div>
