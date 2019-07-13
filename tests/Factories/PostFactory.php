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
                $post->tweet_url = 'https://twitter.com/TwitterAPI/status/1150141056027103247';
                $post->embed_tweet_html ='<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Sunsets don&#39;t get much better than this one over <a href="https://twitter.com/GrandTetonNPS?ref_src=twsrc%5Etfw">@GrandTetonNPS</a>. <a href="https://twitter.com/hashtag/nature?src=hash&amp;ref_src=twsrc%5Etfw">#nature</a> <a href="https://twitter.com/hashtag/sunset?src=hash&amp;ref_src=twsrc%5Etfw">#sunset</a> <a href="http://t.co/YuKy2rcjyU">pic.twitter.com/YuKy2rcjyU</a></p>&mdash; US Department of the Interior (@Interior) <a href="https://twitter.com/Interior/status/463440424141459456?ref_src=twsrc%5Etfw">May 5, 2014</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
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
