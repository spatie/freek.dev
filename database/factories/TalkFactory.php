<?php

use App\Models\Talk;
use Faker\Generator as Faker;

$factory->define(Talk::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'location' => $faker->city . ', ' . $faker->country,
        'presented_at' => $faker->dateTimeBetween('-5 years'),
        'slides_link' => $faker->boolean(50) ? $faker->url : '',
        'video_link' => $faker->boolean(50) ? $faker->url : '',
        'joindin_link' => $faker->boolean(50) ? $faker->url : '',
    ];
});
