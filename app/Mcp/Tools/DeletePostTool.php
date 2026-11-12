<?php

namespace App\Mcp\Tools;

use App\Models\Post;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;

#[Name('delete-post')]
#[Description('Permanently delete a post by ID. This cannot be undone. Inspect with get-post and confirm the intended deletion with the user first, then pass confirm=true. Returns the deleted ID; a repeated call reports that the ID no longer exists.')]
#[IsDestructive]
class DeletePostTool extends Tool
{
    public function handle(Request $request): ResponseFactory
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:posts,id'],
            'confirm' => ['required', 'accepted'],
        ]);

        Post::findOrFail($validated['id'])->delete();

        return Response::structured(['deleted_post_id' => (int) $validated['id']]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->min(1)->description('Post ID to permanently delete.')->required(),
            'confirm' => $schema->boolean()->enum([true])->description('True only after the user confirms deletion of this post.')->required(),
        ];
    }
}
