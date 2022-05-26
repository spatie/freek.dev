<?php

use Faker\Factory;
use Faker\Generator;

function faker(): Generator
{
    return Factory::create();
}
