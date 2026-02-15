<?php

namespace Database\Factories;

use App\Enums\Emoji;
use App\Models\Commenter;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'commenter_id' => Commenter::factory(),
            'reactable_type' => (new Post)->getMorphClass(),
            'reactable_id' => Post::factory(),
            'emoji' => $this->faker->randomElement(Emoji::cases())->value,
        ];
    }
}
