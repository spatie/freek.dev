<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Redirect;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Tags\Tag;
use stdClass;

class ImportWp extends Command
{
    protected $signature = 'import:wp';

    protected $description = 'Import the old WordPress database';

    public function handle()
    {
        $this->truncateTables();

        $oldPosts = DB::table('wp_posts')
            ->where('post_status', 'publish')
            ->where('post_type', 'post')
            ->get();

        collect($oldPosts)
            ->each(function (stdClass $oldPost) {
                $post = Post::create([
                    'title' => $oldPost->post_title,
                    'text' => $this->sanitizePostContent($oldPost->post_content),
                    'wp_post_name' => $oldPost->post_name,
                    'wp_id' => $oldPost->ID,
                    'publish_date' => Carbon::createFromFormat('Y-m-d H:i:s', $oldPost->post_date),
                    'published' => true,
                    'tweet_sent' => true,
                    'posted_on_medium' => true,
                ]);

                $this->attachTags($oldPost, $post);

                $this->createRedirect($post);
            });
    }

    protected function truncateTables()
    {
        Schema::disableForeignKeyConstraints();

        Post::truncate();
        Tag::truncate();
        Redirect::truncate();

        Schema::enableForeignKeyConstraints();
    }

    protected function createRedirect(Post $post)
    {
        Redirect::create([
            'old_url' => $post->wordpress_full_url,
            'new_url' => action('Front\PostsController@detail', $post->slug)
        ]);
    }

    protected function sanitizePostContent(string $postContent): string
    {
        $postContent = str_replace('-700x458', '', $postContent);

        $postContent = str_replace('-700x459', '', $postContent);

        $postContent = str_replace('https://murze.be/wp-content/uploads', '/uploads', $postContent);

        return $postContent;
    }

    protected function attachTags(stdClass $oldPost, Post $post)
    {
        $tags = DB::select(DB::raw("SELECT * FROM wp_terms
                 INNER JOIN wp_term_taxonomy
                 ON wp_term_taxonomy.term_id = wp_terms.term_id
                 INNER JOIN wp_term_relationships
                 ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                 WHERE taxonomy = 'post_tag' AND object_id = {$oldPost->ID}"));

        collect($tags)
            ->map(function (stdClass $tag) {
                return $tag->name;
            })
            ->pipe(function (Collection $tags) use ($post) {
                return $post->attachTags($tags);
            });
    }
}
