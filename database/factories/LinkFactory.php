<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement([
            Link::STATUS_SUBMITTED,
            Link::STATUS_APPROVED,
            Link::STATUS_REJECTED,
        ]);

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'text' => $this->faker->paragraph(),
            'status' => $status,
            'publish_date' => $status === Link::STATUS_APPROVED ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
        ];
    }
}
