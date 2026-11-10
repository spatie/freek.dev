<?php

namespace App\Mcp\Tools;

use App\Actions\SavePostAction;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;

#[Name('update-post')]
#[Description('Update an existing post by ID, returning the saved post and preview URL. Only send fields to change; omitted fields are preserved. Set text=null to remove tweet commentary. Changing shared_tweet_url imports the new tweet unless both snapshot fields are supplied. Set published=true only when asked to publish, or published=false with a future publish_date to schedule. Editing a published post changes the live site. Use get-post to inspect first.')]
#[IsDestructive]
class UpdatePostTool extends CreatePostTool
{
    public function handle(Request $request, SavePostAction $savePost): ResponseFactory
    {
        $validated = $request->validate(['id' => ['required', 'integer', 'exists:posts,id']]);
        $post = $savePost->execute($request->all(), Post::findOrFail($validated['id']));

        return Response::structured(['post' => (new PostResource($post))->resolve()]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        $fields = parent::schema($schema);
        $fields['title']->required(false);

        return [
            'id' => $schema->integer()->min(1)->description('Post ID returned by list-posts, get-post, or create-post.')->required(),
            ...$fields,
        ];
    }
}
