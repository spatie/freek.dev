<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommenterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'github_id' => $this->faker->unique()->randomNumber(8),
            'username' => $this->faker->userName(),
            'name' => $this->faker->name(),
            'avatar_url' => 'https://avatars.githubusercontent.com/u/' . $this->faker->randomNumber(8),
            'token' => hash('sha256', $this->faker->uuid()),
            'is_admin' => false,
        ];
    }

    public function admin(): static
    {
        return $this->state(['is_admin' => true]);
    }
}
