<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Webmention;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factory;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class WebmentionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Webmention::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement([
        Webmention::TYPE_LIKE,
        Webmention::TYPE_REPLY,
        Webmention::TYPE_RETWEET,
    ]);

        return [
        'post_id' => Post::factory(),
        'type' => $type,
        'webmention_id' => $this->faker->randomNumber(),
        'author_name' => $this->faker->name,
        'author_url' => $this->faker->url,
        'author_photo_url' => $this->faker->imageUrl,
        'interaction_url' => $this->faker->url,
        'text' => $type === Webmention::TYPE_REPLY ? $this->faker->sentence : null,
    ];
    }
}
