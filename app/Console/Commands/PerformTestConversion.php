<?php

namespace App\Console\Commands;

use App\Actions\ConvertPostTextToHtmlAction;
use App\Models\Post;
use Illuminate\Console\Command;

class PerformTestConversion extends Command
{
    protected $signature = 'test-conversion {id}';

    public function handle()
    {
        $id = $this->argument('id');

        $post = Post::find($id);

        if (! $post) {
            $this->error("Post {$id} not found...");

            return;
        }

        (new ConvertPostTextToHtmlAction())->execute($post);

        $this->info('Done ' . $id);
    }
}
