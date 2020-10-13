<?php

namespace App\View\Components;

use App\Models\Post;
use Illuminate\View\Component;

class SeriesTocComponent extends Component
{
    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('components.series-toc-component', [
            'currentPost' => $this->post,
            'allPostsInSeries' => $this->post->getAllPostsInSeries(),
        ]);
    }
}
