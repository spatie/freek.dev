<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        Ad::create([
            'display_on_url' => '',
            'text' => <<<'MD'
[Oh Dear](https://ohdear.app) monitors your entire website — uptime, SSL certificates, broken links, scheduled tasks, and more.

Something wrong? You'll know before your users do.

Great docs, a developer-friendly API, and public status pages in under a minute. [Start a free trial](https://ohdear.app).
MD,
            'starts_at' => now()->subDays(30)->toDateString(),
            'ends_at' => now()->addDays(90)->toDateString(),
        ]);

        Ad::create([
            'display_on_url' => '',
            'text' => <<<'MD'
[Flare](https://flareapp.io) is a Laravel-first error tracker. Context-rich stack traces, instant notifications, and AI-powered solutions.

Stop guessing. [Start tracking errors for free](https://flareapp.io).
MD,
            'starts_at' => now()->addDays(91)->toDateString(),
            'ends_at' => now()->addDays(180)->toDateString(),
        ]);

        Ad::create([
            'display_on_url' => '',
            'text' => <<<'MD'
[Mailcoach](https://mailcoach.app) — self-hosted email marketing. Campaigns, drip sequences, and transactional mail.

No monthly fees. Your server, your data. [Try Mailcoach](https://mailcoach.app).
MD,
            'starts_at' => now()->addDays(181)->toDateString(),
            'ends_at' => now()->addDays(270)->toDateString(),
        ]);
    }
}
