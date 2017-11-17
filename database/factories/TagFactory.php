<?php

use Faker\Generator as Faker;
use Spatie\Tags\Tag;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
