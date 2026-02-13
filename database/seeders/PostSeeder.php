<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Bus;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Bus::fake();

        $this->createOriginals();
        $this->createLinks();
        $this->createOlderPosts();
    }

    protected function createOlderPosts(): void
    {
        $tags = ['Laravel', 'PHP', 'AI', 'Packages', 'Open Source', 'Performance', 'Testing'];

        Post::factory()
            ->count(30)
            ->sequence(fn ($sequence) => [
                'publish_date' => now()->subDays(50 + $sequence->index * 3),
                'original_content' => $sequence->index % 3 === 0,
            ])
            ->create()
            ->each(function (Post $post) use ($tags) {
                $post->attachTags(fake()->randomElements($tags, fake()->numberBetween(1, 3)));
            });
    }

    protected function createOriginals(): void
    {
        $originals = [
            [
                'title' => 'Another new Spatie package drops: spatie/laravel-screenshot',
                'text' => "We just released [laravel-screenshot](https://github.com/spatie/laravel-screenshot), a new package to take screenshots of web pages in Laravel apps.\n\nIt uses a driver-based architecture, so you can choose between Browsershot (which requires you to install Chromium) and Cloudflare Browser Rendering (which can be used on environments like Laravel Cloud).\n\nLet me walk you through the package.",
                'tags' => ['Laravel', 'Packages', 'Open Source'],
                'publish_date' => now()->subDays(1),
            ],
            [
                'title' => 'Laravel Permission v7 has been launched',
                'text' => "Laravel's built-in authorization is great when permissions are defined in code. But in some projects roles and permissions are dynamic: created by users, managed through an admin panel, or changed at runtime without deploying code.\n\nOur [Laravel Permission](https://spatie.be/docs/laravel-permission/v7/introduction) package can help you dynamically create roles and permissions.\n\nWe just released v7 which cleans up the internal code and modernizes it. Let me walk you through what the package can do.",
                'tags' => ['Laravel', 'Packages', 'Open Source'],
                'publish_date' => now()->subDays(2),
            ],
            [
                'title' => 'Laravel PDF v2 has been released: adds support for Laravel Cloud and easy queuing',
                'text' => "A while ago, we released [laravel-pdf](https://github.com/spatie/laravel-pdf), a package to generate PDFs in Laravel apps.\n\nUnder the hood, it used Browsershot (and therefore Puppeteer/Chrome) to convert HTML to PDF. That approach works great, but it does require Node.js and a headless Chrome binary on your server.\n\nTo support a simpler approach, we've released a new major release (v2) of Laravel PDF. The package now ships with three drivers: Browsershot, Cloudflare Browser Rendering, and DOMPDF.",
                'tags' => ['Laravel', 'Packages', 'Open Source'],
                'publish_date' => now()->subDays(5),
            ],
            [
                'title' => 'Introducing Ray 3.0',
                'text' => "Ray 3.0 is here! Completely rebuilt for better performance (60% less memory), a fresh new look, message archiving, and MCP support so AI agents can interact with Ray directly.\n\nIn this post I'll walk you through the highlights of this release.",
                'tags' => ['Ray', 'Debugging', 'Open Source'],
                'publish_date' => now()->subDays(8),
            ],
            [
                'title' => 'I built a native mobile word game in two weeks',
                'text' => "At Laracon India, I launched a major update of Ray. For that talk, I needed a little demo project to showcase Ray. I built a simple website about a then-fictional mobile app to play a Scrabble-like word game called WordStockt.\n\nBut then I got curious: how far could I push AI-assisted development? Could I actually just create the whole game? After about 10 days, WordStockt is a fully functional word game that's 98% vibe-coded.",
                'tags' => ['AI'],
                'publish_date' => now()->subDays(13),
            ],
            [
                'title' => 'Introducing Spatie Guidelines for Laravel Boost',
                'text' => "If you're using AI tools like Claude Code to help write code, you've probably noticed they don't automatically know your team's coding conventions. The AI might write perfectly valid PHP, but it won't follow your specific style guide unless you tell it to.\n\nThat's the problem Laravel Boost solves.",
                'tags' => ['Laravel', 'AI', 'Packages'],
                'publish_date' => now()->subDays(17),
            ],
            [
                'title' => 'How to automatically generate a commit message using Claude',
                'text' => "For years, my git history contains \"wip\" commit messages. I don't really often use git history myself, but my colleagues do. And when they're trying to understand a change I made six months ago, \"wip\" tells them absolutely nothing.\n\nNow, I have a bash function in my dotfiles that uses Claude to generate commit messages for me.",
                'tags' => ['AI'],
                'publish_date' => now()->subDays(18),
            ],
            [
                'title' => 'A practical guide to event sourcing in Laravel',
                'text' => "In an event sourced app you're storing each event that happens within your app and derive all state from those events.\n\nIn this practical post you'll get an intro on what event sourcing is and what the benefits are. After that we'll dive into the Laravel ecosystem and take a look at how we can create projectors and aggregates using the laravel-event-sourcing package.",
                'tags' => ['Laravel', 'Event Sourcing', 'Packages'],
                'publish_date' => now()->subDays(25),
            ],
            [
                'title' => 'Handling media in a Laravel application',
                'text' => "In most CMS kind of projects you're going to let a user upload all sorts of images and files. Storing those files, associating them with models, creating thumbnails for them, optimizing images, can be a lot of work.\n\nLuckily laravel-medialibrary can do all that for you. In this post you'll see a practical guide of how to get started with the medialibrary.",
                'tags' => ['Laravel', 'Media Library', 'Packages'],
                'publish_date' => now()->subDays(30),
            ],
            [
                'title' => 'Building multi-tenant applications in Laravel',
                'text' => "Multi-tenancy is a common requirement for SaaS applications. In this post, we'll explore different approaches to implementing multitenancy in Laravel using our laravel-multitenancy package.\n\nWe'll look at database-per-tenant, single database with tenant scoping, and how to handle tenant identification through domains and subdomains.",
                'tags' => ['Laravel', 'Packages'],
                'publish_date' => now()->subDays(40),
            ],
        ];

        foreach ($originals as $original) {
            $tags = $original['tags'];
            unset($original['tags']);

            $post = Post::factory()->create(array_merge($original, [
                'original_content' => true,
                'published' => true,
            ]));

            $post->attachTags($tags);
        }
    }

    protected function createLinks(): void
    {
        $links = [
            [
                'title' => 'How to create an awesome product launch video',
                'text' => 'Aaron Francis shares how he used Claude to create an entire launch video for his new app, without using any traditional motion graphics software.',
                'external_url' => 'https://x.com/aarondfrancis/status/2019864351096627356',
                'tags' => ['AI'],
                'publish_date' => now()->subDays(1),
            ],
            [
                'title' => 'Laravel Fuse: Circuit breaker for queue jobs',
                'text' => 'Laravel Fuse is a circuit breaker package for Laravel queue jobs. When an external service goes down, instead of letting thousands of jobs timeout, the circuit opens after a configurable failure threshold and jobs fail instantly.',
                'external_url' => 'https://github.com/harris21/laravel-fuse',
                'tags' => ['Laravel', 'Queues', 'Packages'],
                'publish_date' => now()->subDays(2),
            ],
            [
                'title' => 'Real-world examples of using Laravel AI SDK',
                'text' => 'Amit Merchant walks through practical use cases for the Laravel AI SDK: mining user data with Eloquent models as context, building a code review bot that comments on PRs, and creating adaptive quiz systems.',
                'external_url' => 'https://www.amitmerchant.com/real-world-exmples-using-laravel-api-sdk/',
                'tags' => ['Laravel', 'AI'],
                'publish_date' => now()->subDays(3),
            ],
            [
                'title' => 'The Origin of Laravel - a look at v1 Beta 1',
                'text' => 'A fascinating deep dive into the very first commit of Laravel, made by Taylor Otwell on June 9, 2011. The article explores the original directory structure, the early Eloquent ORM, and the authentication basics that are still recognizable today.',
                'external_url' => 'https://laravelnepal.com/post/origin-of-laravel-v1',
                'tags' => ['Laravel'],
                'publish_date' => now()->subDays(4),
            ],
            [
                'title' => 'Excessive Bold',
                'text' => 'Martin Fowler on the overuse of bold in technical writing — and how LLMs have picked up and spread this practice. The more you emphasize, the less power it has.',
                'external_url' => 'https://martinfowler.com/bliki/ExcessiveBold.html',
                'tags' => [],
                'publish_date' => now()->subDays(7),
            ],
            [
                'title' => 'Personal AI Assistants Changed Everything For Me',
                'text' => 'Christoph reflects on how personal AI assistants have changed his daily workflow — from calendar updates to searching the web less. An interesting take on where this technology is heading.',
                'external_url' => 'https://christoph-rumpel.com/2026/2/personal-ai-assistants-changed-everything-for-me',
                'tags' => ['AI'],
                'publish_date' => now()->subDays(9),
            ],
            [
                'title' => 'Partial function application in PHP 8.6',
                'text' => 'PHP 8.6 will introduce partial function application, allowing you to pre-fill some arguments while leaving others for later. Brent explains this new language feature with practical examples.',
                'external_url' => 'https://stitcher.io/blog/php-86-partial-function-application',
                'tags' => ['PHP'],
                'publish_date' => now()->subDays(10),
            ],
            [
                'title' => 'Once again processing 11 million rows, now in seconds',
                'text' => 'Brent continues his optimization journey processing 11 million database events. Starting from 50k events per second, he reaches 400k events per second. A great deep dive into PHP performance optimization.',
                'external_url' => 'https://stitcher.io/blog/11-million-rows-in-seconds',
                'tags' => ['PHP', 'Performance'],
                'publish_date' => now()->subDays(14),
            ],
            [
                'title' => 'Semantic Diffusion',
                'text' => 'Martin Fowler on how technical terms lose their meaning as they spread. Think of how "agile" or "DevOps" are used today versus their original intent.',
                'external_url' => 'https://martinfowler.com/bliki/SemanticDiffusion.html',
                'tags' => [],
                'publish_date' => now()->subDays(15),
            ],
            [
                'title' => 'SQL performance improvements: automatic detection & regression testing',
                'text' => "The final part of Oh Dear's series on SQL performance. Mattias introduces phpunit-query-count-assertions, a package that catches N+1 queries, duplicate queries, and missing indexes in your test suite.",
                'external_url' => 'https://ohdear.app/news-and-updates/sql-performance-improvements',
                'tags' => ['Laravel', 'Performance', 'Oh Dear', 'Testing'],
                'publish_date' => now()->subDays(16),
            ],
        ];

        foreach ($links as $link) {
            $tags = $link['tags'];
            unset($link['tags']);

            $post = Post::factory()->create(array_merge($link, [
                'original_content' => false,
                'published' => true,
            ]));

            if (count($tags) > 0) {
                $post->attachTags($tags);
            }
        }
    }
}
