<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Post::each(function(Post $post) {
            if (faker()->boolean) {
                return;
            }

            foreach(range(1, rand(1,10)) as $i) {
                $user = User::all()->random();

                $post->comment(faker()->text, $user);
            }
        });
    }
}
