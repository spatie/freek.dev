<?php

use App\Models\Ad;
use Faker\Generator as Faker;

$factory->define(Ad::class, function (Faker $faker) {
    $startsAt = now()->addDays(rand(-30, 30));
    $endsAt = $startsAt->copy()->addDays(30);

    return [
        'display_on_url' => $faker->boolean(50) ? $faker->url : '',
        'text' => $faker->sentence(),
        'starts_at' => $startsAt->toDateString(),
        'ends_at' => $endsAt->toDateString(),
    ];
});
