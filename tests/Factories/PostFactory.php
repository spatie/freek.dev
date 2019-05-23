<?php

namespace Tests\Factories;

use App\Models\Post;
use Illuminate\Support\Arr;

class PostFactory
{
    private $tags = [];

    public function withTags($tags)
    {
        $this->tags = Arr::wrap($tags);
    }

    public function create(array $attributes = []): Post
    {
        $post = factory(Post::class)->create($attributes);
    }
}
