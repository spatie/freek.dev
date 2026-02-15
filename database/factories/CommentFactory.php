<?php

namespace Database\Factories;

use App\Models\Commenter;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        $body = $this->faker->paragraph();

        return [
            'commenter_id' => Commenter::factory(),
            'post_id' => Post::factory(),
            'body' => $body,
            'body_html' => Str::markdown($body, ['html_input' => 'strip']),
        ];
    }
}
