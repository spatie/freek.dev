<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\Medium\Medium;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostOnMediumJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**  @var \App\Models\Post */
    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(Medium $medium)
    {
        $medium->createPost(
            $this->post->title,
            $this->post->formatted_text,
            $this->post->tags->pluck('name')->toArray(),
            $this->post->url
        );
    }
}
