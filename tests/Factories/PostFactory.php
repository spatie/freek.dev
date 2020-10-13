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
                ]);
                $post->title = $this->faker()->sentence;
            }

            if ($this->type === Post::TYPE_TWEET) {
                $post->original_content = false;
                $post->external_url = '';
                $post->title = $this->faker()->sentence;
                $post->attachTag('tweet');
                $post->text = $this->getStub('tweet');
            }

            if ($this->type === Post::TYPE_ORIGINAL) {
                $post->original_content = true;
                $post->external_url = '';
                $post->title = $this->faker()->sentence;
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
        return file_get_contents(__DIR__ . "/stubs/{$stubName}.md");
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
                $firstSentence = "On [our Laravel powered company website](https://spatie.be) we sell digital products. ";

                $post->update(['text' => "{$firstSentence}{$post->text}"]);
            }
        }

        return $posts;
    }
}
