<?php

namespace App\Console\Commands;

use App\Jobs\CreateOgImageJob;
use App\Models\Post;
use Illuminate\Console\Command;

class RegenerateOgImagesCommand extends Command
{
    protected $signature = 'regenerate-og-images';

    public function handle()
    {
        Post::query()->latest()->limit(200)->each(function(Post $post) {
        dispatch(new CreateOgImageJob($post));
        });

        $this->info('All done!');
    }
}
