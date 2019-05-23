<?php

use App\Models\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'text' => $faker->paragraph,
        'publish_date' => $faker->boolean(50) ? $faker->dateTimeBetween('-5 years') : null,
        'published' => true,
        'original_content' => $faker->boolean(10),
    ];
});
