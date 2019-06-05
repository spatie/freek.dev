<?php

namespace App\Models\Concerns;

interface Sluggable
{
    public function getSluggableValue(): string;
}
