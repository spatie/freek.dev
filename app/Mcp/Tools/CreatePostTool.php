<?php

namespace App\Mcp\Tools;

use App\Actions\SavePostAction;
use App\Http\Resources\PostResource;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;

#[Name('create-post')]
#[Description('Create a blog post, community link, or shared tweet. Returns the saved post and preview URL. Defaults to a draft; set published=true only when asked to publish. For a tweet, supply title and shared_tweet_url; X imports author/text automatically. Optional text is your Markdown commentary. If importing fails or X truncates a long tweet, supply shared_tweet_author and shared_tweet_text yourself. Creating again makes another post: use list-posts to check before retrying an uncertain result, or update-post to edit.')]
#[IsDestructive(false)]
class CreatePostTool extends Tool
{
    public function handle(Request $request, SavePostAction $savePost): ResponseFactory
    {
        $post = $savePost->execute($request->all());

        return Response::structured(['post' => (new PostResource($post))->resolve()]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->max(255)->description('Post title, including for shared tweets.')->required(),
            'text' => $schema->string()->nullable()->description('Markdown body; required for regular posts. Optional commentary for a shared tweet; null removes that commentary.'),
            'shared_tweet_url' => $schema->string()->max(255)->nullable()->description('Original tweet URL, e.g. https://x.com/laravel_idea/status/2120086850107048073. Sets the post type to tweet. Changing it imports a fresh snapshot unless author and tweet text are supplied together. Null converts back to a regular post with a required non-empty text body.'),
            'shared_tweet_author' => $schema->string()->max(255)->nullable()->description('Original tweet author display name; omit to import from X.'),
            'shared_tweet_text' => $schema->string()->max(20000)->nullable()->description('Original tweet plain text, preserving line breaks. Omit to import from X. Required together with shared_tweet_author to skip importing. Review long tweets because X may truncate them.'),
            'published' => $schema->boolean()->description('True publishes immediately; false keeps unpublished. Defaults to false on creation; omitted on update preserves the current status.'),
            'publish_date' => $schema->string()->nullable()->description('ISO 8601 timestamp with timezone. With published=false, schedules automatic publication when due. Null leaves a draft unscheduled.'),
            'original_content' => $schema->boolean()->description('True for your own original articles; false for community links. Always false for shared tweets. Defaults to false.'),
            'external_url' => $schema->string()->max(255)->nullable()->description('Source URL for a community link, not the shared tweet URL.'),
            'tags' => $schema->array()->items($schema->string()->max(255))->description('Tag names. Replaces the complete tag list when supplied; [] clears tags. Omit to preserve existing tags. Shared tweets need no special tag.'),
            'send_automated_tweet' => $schema->boolean()->description('Opt in to promoting a regular post on X when published. Defaults to false. Shared tweet posts are never promoted.'),
            'author_twitter_handle' => $schema->string()->max(255)->nullable()->description('Source article author handle for attribution; not the saved tweet author.'),
            'series_slug' => $schema->string()->max(255)->nullable()->description('Existing series slug, or null to remove from a series.'),
        ];
    }
}
