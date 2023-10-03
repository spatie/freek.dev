<?php

namespace App\View\Components;

use App\Models\Post;
use Illuminate\View\Component;

class SeriesNextPostComponent extends Component
{
    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        $nextPost = Post::query()
            ->where('series_slug', $this->post->series_slug)
            ->where('id', '>', $this->post->id)
            ->orderBy('id')
            ->first();

        return view('components.series-next-post-component', [
            'nextPost' => $nextPost,
            'post' => $this->post,
        ]);
    }
}
