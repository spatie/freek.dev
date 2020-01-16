<?php

use App\Models\Link;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Link::class, function (Faker $faker) {
    $status = $faker->randomElement([
        Link::STATUS_SUBMITTED,
        Link::STATUS_APPROVED,
        Link::STATUS_REJECTED
    ]);

    return [
        'user_id' => factory(User::class),
        'title' => $faker->sentence(),
        'text' => $faker->paragraph,
        'status' => $status,
        'publish_date' => $status === Link::STATUS_APPROVED ? $faker->dateTimeBetween('-1 year', 'now') : null,
    ];
});
