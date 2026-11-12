<?php

namespace App\Mcp\Tools;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Name('get-post')]
#[Description('Read a post by ID, including its Markdown, saved tweet, tags, publication status, and preview URL. Use list-posts to find IDs, and inspect the post before editing or deleting it.')]
#[IsReadOnly]
class GetPostTool extends Tool
{
    public function handle(Request $request): ResponseFactory
    {
        $validated = $request->validate(['id' => ['required', 'integer', 'exists:posts,id']]);
        $post = Post::findOrFail($validated['id']);

        return Response::structured(['post' => (new PostResource($post))->resolve()]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->min(1)->description('Post ID returned by list-posts or create-post.')->required(),
        ];
    }
}
