<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Webmention;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebmentionFactory extends Factory
{
    public function definition(): array
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
            'author_name' => $this->faker->name(),
            'author_url' => $this->faker->url(),
            'author_photo_url' => $this->faker->imageUrl(),
            'interaction_url' => $this->faker->url(),
            'text' => $type === Webmention::TYPE_REPLY ? $this->faker->sentence() : null,
        ];
    }
}
