<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */
use App\Models\Newsletter;
use Faker\Generator as Faker;

$factory->define(Newsletter::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'url' => $faker->url,
        'description' => $faker->paragraph,
        'sent_at' => $faker->dateTimeBetween('-1 year'),
    ];
});
