<?php

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'text' => $faker->paragraph,
        'publish_date' => $faker->boolean(50) ? $faker->dateTimeBetween('-5 years') : null,
        'published' => $faker->boolean(80),
        'original_content' => $faker->boolean(10),
    ];
});
