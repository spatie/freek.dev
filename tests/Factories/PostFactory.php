<?php

namespace Tests\Factories;

use App\Models\Post;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PostFactory
{
    private int $times;

    private ?string $type;

    public function __construct(int $times = 1)
    {
        $this->times = $times;
    }

    public function tweet()
    {
        $this->type = Post::TYPE_TWEET;

        return $this;
    }

    public function original()
    {
        $this->type = Post::TYPE_ORIGINAL;

        return $this;
    }

    public function link()
    {
        $this->type = Post::TYPE_LINK;

        return $this;
    }

    public function create(array $attributes = [])
    {
        foreach (range(1, $this->times) as $i) {
            /** @var \App\Models\Post $post */
            $post = Post::factory()->create($attributes);
            if (is_null($this->type)) {
                $this->type = Arr::random([
                    Post::TYPE_LINK,
                    Post::TYPE_ORIGINAL,
                    Post::TYPE_TWEET,
                ]);
            }

            if ($this->type === Post::TYPE_LINK) {
                $post->original_content = false;
                $post->external_url = $this->faker()->randomElement([
                    'https://spatie.be',
                    'https://laravel.com',
                    'https://ohdear.app',
                    'https://flareapp.io',
                    'https://stitcher.io',
                    'https://martinfowler.com',
                ]);
                $post->title = $this->faker()->randomElement([
                    'Laravel Fuse: Circuit breaker for queue jobs',
                    'Real-world examples of using Laravel AI SDK',
                    'The Origin of Laravel - a look at v1 Beta 1',
                    'Excessive Bold',
                    'Partial function application in PHP 8.6',
                    'Once again processing 11 million rows, now in seconds',
                    'SQL performance improvements: automatic detection & regression testing',
                    'Personal AI Assistants Changed Everything For Me',
                ]);
            }

            if ($this->type === Post::TYPE_TWEET) {
                $post->original_content = false;
                $post->external_url = '';
                $post->title = $this->faker()->randomElement([
                    'How to create an awesome product launch video',
                    'TIL: Laravel has native eager loading limits now',
                    'Just shipped Ray 3.0 with MCP support',
                    'The new PHP 8.6 partial function application is neat',
                    'Circuit breakers for queue jobs are a game changer',
                    'Interesting thread on AI-assisted development workflows',
                ]);
                $post->attachTag('tweet');
                $post->text = $this->getStub('tweet');
            }

            if ($this->type === Post::TYPE_ORIGINAL) {
                $post->original_content = true;
                $post->external_url = '';
                $post->title = $this->faker()->randomElement([
                    'Another new Spatie package drops: spatie/laravel-screenshot',
                    'Laravel Permission v7 has been launched',
                    'Laravel PDF v2 has been released: adds support for Laravel Cloud',
                    'Introducing Ray 3.0',
                    'I built a native mobile word game in two weeks',
                    'Introducing Spatie Guidelines for Laravel Boost',
                    'How to automatically generate a commit message using Claude',
                    'A practical guide to event sourcing in Laravel',
                ]);
                $post->text = $this->getStub('original');
                $post->tweet_url = 'https://twitter.com/TwitterAPI/status/1150141056027103247';
            }

            $post->save();
        }

        if ($this->times === 1) {
            return $post;
        }
    }

    protected function faker(): Generator
    {
        return Factory::create();
    }

    protected function getStub(string $stubName): string
    {
        return file_get_contents(__DIR__."/stubs/{$stubName}.md");
    }

    public static function series(int $count): Collection
    {
        $posts = Post::factory()->count($count)->create([
            'title' => 'Test post',
            'original_content' => true,
            'published' => true,
            'series_slug' => 'test-series',
            'text' => '[series-toc] This is the blog post [series-next-post]',
        ]);

        foreach ($posts as $i => $post) {
            $post->update(['title' => "Series title part {$i}: Lorem ipsum"]);

            if ($i === 0) {
                $firstSentence = 'On [our Laravel powered company website](https://spatie.be) we sell digital products. ';

                $post->update(['text' => "{$firstSentence}{$post->text}"]);
            }
        }

        return $posts;
    }
}
