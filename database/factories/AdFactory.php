<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    public function definition(): array
    {
        $ads = [
            '[Oh Dear](https://ohdear.app) is the all-in-one monitoring tool for your entire website. We monitor uptime, SSL certificates, broken links, scheduled tasks and more. Start monitoring using our [free trial](https://ohdear.app) now.',
            '[Flare](https://flareapp.io) is the error tracker that treats Laravel as a first-class citizen. Track every error, get context-rich stack traces, and fix bugs faster. Try [Flare](https://flareapp.io) for free.',
            '[Mailcoach](https://mailcoach.app) is a self-hosted email marketing platform. Send newsletters, set up drip campaigns, and handle transactional emails. All without a monthly subscription.',
        ];

        $startsAt = now()->addDays(rand(-30, 30));
        $endsAt = $startsAt->copy()->addDays(30);

        return [
            'display_on_url' => '',
            'text' => $this->faker->randomElement($ads),
            'starts_at' => $startsAt->toDateString(),
            'ends_at' => $endsAt->toDateString(),
        ];
    }
}
