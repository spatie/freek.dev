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

#[Name('list-posts')]
#[Description('Find posts, including drafts and shared tweets. Filter by title search, published status, original content, or tag. Returns posts and pagination; use get-post for one ID. Check here before creating a post to avoid duplicates.')]
#[IsReadOnly]
class ListPostsTool extends Tool
{
    public function handle(Request $request): ResponseFactory
    {
        $filters = $request->validate([
            'search' => ['string', 'max:255'],
            'published' => ['boolean'],
            'original_content' => ['boolean'],
            'tag' => ['string', 'max:255'],
            'page' => ['integer', 'min:1'],
            'per_page' => ['integer', 'min:1', 'max:50'],
        ]);

        $query = Post::query()->latest('publish_date')->latest('id');

        foreach (['published', 'original_content'] as $field) {
            if (array_key_exists($field, $filters)) {
                $query->where($field, $filters[$field]);
            }
        }

        if (isset($filters['tag'])) {
            $query->withAnyTags([$filters['tag']]);
        }

        if (isset($filters['search'])) {
            $query->where('title', 'like', "%{$filters['search']}%");
        }

        $posts = $query->paginate($filters['per_page'] ?? 15, page: $filters['page'] ?? 1);

        return Response::structured([
            'posts' => PostResource::collection($posts->items())->resolve(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'total' => $posts->total(),
        ]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'search' => $schema->string()->max(255)->description('Match a substring in the post title.'),
            'published' => $schema->boolean()->description('True for published posts, false for drafts and scheduled posts. Omit for both.'),
            'original_content' => $schema->boolean()->description('True for original articles, false for community links and tweets. Omit for both.'),
            'tag' => $schema->string()->max(255)->description('Match a tag name.'),
            'page' => $schema->integer()->min(1)->description('Page number, starting at 1; defaults to 1.'),
            'per_page' => $schema->integer()->min(1)->max(50)->description('Posts per page, 1–50; defaults to 15.'),
        ];
    }
}
