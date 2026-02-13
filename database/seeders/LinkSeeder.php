<?php

namespace Database\Seeders;

use App\Enums\LinkStatus;
use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $links = [
            [
                'title' => 'Running PHP 8.5 with Laravel Octane and FrankenPHP',
                'url' => 'https://danielpetrica.com/running-php-8-5-with-laravel-octane-and-frankenphp',
                'text' => 'A quick but essential fix for anyone pushing the edges of the Laravel ecosystem. The default FrankenPHP binary is locked to PHP 8.4, which causes major headaches if your application relies on PHP 8.5 features.',
                'status' => LinkStatus::Approved,
                'publish_date' => now()->subDays(3),
            ],
            [
                'title' => 'From dd() to Ray: A Debugging Workflow That Doesn\'t Break Your Flow',
                'url' => 'https://tnakov.dev/from-dd-to-ray-debugging-workflow-that-doesnt-break-your-flow',
                'text' => 'Evolving from dd() to Ray for a smoother workflow. Explore how Ray can boost your debugging game without stopping your code!',
                'status' => LinkStatus::Approved,
                'publish_date' => now()->subDays(5),
            ],
            [
                'title' => 'New in Parental v1.5.0: Becoming, Integers, and Eager-Loading',
                'url' => 'https://tighten.com/insights/new-parental-features-v1-5-0/',
                'text' => 'Version v1.5.0 of Parental adds support for Single Table Inheritance type transformations, numeric type columns, and new helper methods for eager-loading.',
                'status' => LinkStatus::Approved,
                'publish_date' => now()->subDays(8),
            ],
            [
                'title' => 'Laravel Herd for Linux',
                'url' => 'https://herd.laravel.com',
                'text' => 'Laravel Herd is now available for Linux. One click PHP development environments with zero configuration.',
                'status' => LinkStatus::Approved,
                'publish_date' => now()->subDays(12),
            ],
            [
                'title' => 'Building a SaaS with Laravel and Stripe',
                'url' => 'https://laravel-news.com/building-saas-stripe',
                'text' => 'A comprehensive guide to integrating Stripe into your Laravel SaaS application, covering subscriptions, invoices, and webhooks.',
                'status' => LinkStatus::Approved,
                'publish_date' => now()->subDays(15),
            ],
            [
                'title' => 'A practical guide to PHP generics with PHPStan',
                'url' => 'https://phpstan.org/blog/generics-in-php-using-phpdocs',
                'text' => 'Learn how to use PHPDoc generics with PHPStan for better type safety in your PHP applications.',
                'status' => LinkStatus::Submitted,
                'publish_date' => null,
            ],
            [
                'title' => 'Understanding container orchestration for PHP apps',
                'url' => 'https://example.com/container-orchestration-php',
                'text' => 'A primer on using Docker and Kubernetes to deploy and scale PHP applications in production.',
                'status' => LinkStatus::Submitted,
                'publish_date' => null,
            ],
            [
                'title' => 'Why I switched from Next.js to Laravel + Livewire',
                'url' => 'https://example.com/nextjs-to-livewire',
                'text' => 'A developer shares their experience migrating from a React/Next.js stack to Laravel with Livewire and why they never looked back.',
                'status' => LinkStatus::Rejected,
                'publish_date' => null,
            ],
        ];

        foreach ($links as $link) {
            Link::factory()->create(array_merge($link, [
                'user_id' => $user->id,
            ]));
        }
    }
}
