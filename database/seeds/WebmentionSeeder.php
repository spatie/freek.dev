<?php

use App\Models\Post;
use App\Models\Webmention;
use Illuminate\Database\Seeder;

class WebmentionSeeder extends Seeder
{
    public function run()
    {
        Post::each(function (Post $post) {
            factory(Webmention::class, 10)->create([
                'post_id' => $post->id,
            ]);
        });
    }
}
