<?php

namespace Database\Factories;

use App\Enums\LinkStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement([
            LinkStatus::Submitted,
            LinkStatus::Approved,
            LinkStatus::Rejected,
        ]);

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'text' => $this->faker->paragraph(),
            'status' => $status,
            'publish_date' => $status === LinkStatus::Approved ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
        ];
    }
}
