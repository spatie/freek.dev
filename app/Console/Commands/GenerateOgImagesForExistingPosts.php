<?php

namespace App\Console\Commands;

use App\Jobs\CreateOgImageJob;
use App\Models\Post;
use Illuminate\Console\Command;

class GenerateOgImagesForExistingPosts extends Command
{
    protected $signature = 'generate-og-images';

    protected $description = 'Generate og images for existing posts';

    public function handle()
    {
        Post::orderByDesc('created_at')->where('original_content', true)->take(10)->each(function (Post $post) {
            dispatch(new CreateOgImageJob($post));
        });

        $this->info('All done!');
    }
}
