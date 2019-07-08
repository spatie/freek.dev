<?php

use App\Models\Post;
use App\Models\Webmention;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Webmention::class, function (Faker $faker) {
    $type = $faker->randomElement([
        Webmention::TYPE_LIKE,
        Webmention::TYPE_REPLY,
        Webmention::TYPE_RETWEET
    ]);

    return [
        'post_id' => factory(Post::class),
        'type' => $type,
        'webmention_id' => $faker->randomNumber(),
        'author_name' => $faker->name,
        'author_url' => $faker->url,
        'author_photo_url' => $faker->imageUrl,
        'interaction_url' => $faker->url,
        'text'  => $type === Webmention::TYPE_REPLY ? $faker->sentence : null,
    ];
});
