<?php

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'text' => $faker->paragraph,
        'publish_date' => $faker->dateTimeBetween('-5 years'),
        'published' => $faker->boolean(90),
        'original_content' => $faker->boolean(10),
    ];
});
