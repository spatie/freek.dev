<?php

namespace Tests\Factories;

use App\Models\Post;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Arr;

class PostFactory
{
    /** @var int */
    private $times;

    /** @var string|null */
    private $type;

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
            $post = factory(Post::class)->create($attributes);
            if (is_null($this->type)) {
                $this->type = Arr::random([
                    Post::TYPE_LINK,
                    Post::TYPE_ORIGINAL,
                    Post::TYPE_TWEET,
                ]);
            }

            if ($this->type === Post::TYPE_LINK) {
                $post->original_content = false;
                $post->external_url = $this->faker()->url;
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
}
