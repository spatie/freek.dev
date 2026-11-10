<?php

use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('returns 401 for unauthenticated requests', function () {
    $this->callPostTool('list-posts')->assertUnauthorized();
});

it('returns 403 for non-admin users', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->callPostTool('list-posts')->assertForbidden();
});

it('accepts an existing admin bearer token and advertises its tools and instructions', function () {
    $token = $this->admin->createToken('ai-tool')->plainTextToken;

    $this->withToken($token)->postJson('/mcp/posts', [
        'jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize',
        'params' => ['protocolVersion' => '2025-11-25', 'capabilities' => [], 'clientInfo' => ['name' => 'Test', 'version' => '1.0']],
    ])->assertSuccessful()->assertJsonPath('result.serverInfo.name', 'freek.dev posts');

    $response = $this->postJson('/mcp/posts', ['jsonrpc' => '2.0', 'id' => 2, 'method' => 'tools/list'])
        ->assertSuccessful()->assertJsonCount(5, 'result.tools');

    $tools = collect($response->json('result.tools'))->keyBy('name');

    expect($tools->keys()->all())->toBe(['list-posts', 'get-post', 'create-post', 'update-post', 'delete-post']);
    expect($tools['create-post']['inputSchema']['required'])->toBe(['title']);
    expect($tools['update-post']['inputSchema']['required'])->toBe(['id']);
    expect($tools['create-post']['inputSchema']['properties'])->toHaveKeys(['shared_tweet_url', 'shared_tweet_text', 'text']);
    expect($tools['list-posts']['annotations']['readOnlyHint'])->toBeTrue();
    expect($tools['delete-post']['annotations']['destructiveHint'])->toBeTrue();

    $this->callPostTool('list-posts')->assertSuccessful()->assertJsonPath('result.isError', false);
});

it('can list posts', function () {
    Post::factory()->count(3)->create();

    Sanctum::actingAs($this->admin);

    $this->callPostTool('list-posts')
        ->assertSuccessful()
        ->assertJsonCount(3, 'result.structuredContent.posts');
});

it('can filter posts by published status', function () {
    Post::factory()->create(['published' => true]);
    Post::factory()->create(['published' => false]);

    Sanctum::actingAs($this->admin);

    $this->callPostTool('list-posts', ['published' => true])
        ->assertSuccessful()
        ->assertJsonCount(1, 'result.structuredContent.posts')
        ->assertJsonPath('result.structuredContent.posts.0.published', true);

    $this->callPostTool('list-posts', ['published' => false])
        ->assertJsonCount(1, 'result.structuredContent.posts')
        ->assertJsonPath('result.structuredContent.posts.0.published', false);
});

it('can filter posts by original content', function () {
    Post::factory()->create(['original_content' => true]);
    Post::factory()->create(['original_content' => false]);

    Sanctum::actingAs($this->admin);

    $this->callPostTool('list-posts', ['original_content' => true])
        ->assertSuccessful()
        ->assertJsonCount(1, 'result.structuredContent.posts')
        ->assertJsonPath('result.structuredContent.posts.0.original_content', true);

    $this->callPostTool('list-posts', ['original_content' => false])
        ->assertJsonCount(1, 'result.structuredContent.posts')
        ->assertJsonPath('result.structuredContent.posts.0.original_content', false);
});

it('can search posts by title', function () {
    Post::factory()->create(['title' => 'Laravel tips and tricks']);
    Post::factory()->create(['title' => 'PHP best practices']);

    Sanctum::actingAs($this->admin);

    $this->callPostTool('list-posts', ['search' => 'Laravel'])
        ->assertSuccessful()
        ->assertJsonCount(1, 'result.structuredContent.posts')
        ->assertJsonPath('result.structuredContent.posts.0.title', 'Laravel tips and tricks');
});

it('can show a single post', function () {
    $post = Post::factory()->create();

    Sanctum::actingAs($this->admin);

    $this->callPostTool('get-post', ['id' => $post->id])
        ->assertSuccessful()
        ->assertJsonPath('result.structuredContent.post.id', $post->id)
        ->assertJsonPath('result.structuredContent.post.title', $post->title);
});

it('can create a post', function () {
    Sanctum::actingAs($this->admin);

    $this->callPostTool('create-post', [
        'title' => 'A new blog post',
        'text' => 'Some content for the post.',
    ])
        ->assertSuccessful()
        ->assertJsonPath('result.structuredContent.post.title', 'A new blog post')
        ->assertJsonPath('result.structuredContent.post.published', false)
        ->assertJsonPath('result.structuredContent.post.publish_date', null)
        ->assertJsonPath('result.structuredContent.post.send_automated_tweet', false);

    $this->assertDatabaseHas('posts', [
        'title' => 'A new blog post',
        'text' => 'Some content for the post.',
    ]);
});

it('can create a post with tags', function () {
    Sanctum::actingAs($this->admin);

    $this->callPostTool('create-post', [
        'title' => 'Tagged post',
        'text' => 'Content with tags.',
        'tags' => ['laravel', 'php'],
    ])
        ->assertSuccessful()
        ->assertJsonPath('result.structuredContent.post.tags', ['laravel', 'php']);
});

it('validates required fields on store', function () {
    Sanctum::actingAs($this->admin);

    $response = $this->callPostTool('create-post')
        ->assertSuccessful()
        ->assertJsonPath('result.isError', true);

    expect($response->json('result.content.0.text'))->toContain('title', 'text');
    expect(Post::count())->toBe(0);
});

it('can update a post', function () {
    $post = Post::factory()->create();

    Sanctum::actingAs($this->admin);

    $this->callPostTool('update-post', [
        'id' => $post->id,
        'title' => 'Updated title',
    ])
        ->assertSuccessful()
        ->assertJsonPath('result.structuredContent.post.title', 'Updated title')
        ->assertJsonPath('result.structuredContent.post.text', $post->text)
        ->assertJsonPath('result.structuredContent.post.published', $post->published);

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated title',
    ]);
});

it('can update post tags', function () {
    $post = Post::factory()->create();
    $post->syncTags(['old-tag']);

    Sanctum::actingAs($this->admin);

    $this->callPostTool('update-post', [
        'id' => $post->id,
        'tags' => ['new-tag', 'another-tag'],
    ])
        ->assertSuccessful()
        ->assertJsonPath('result.structuredContent.post.tags', ['new-tag', 'another-tag']);

    $this->callPostTool('update-post', ['id' => $post->id, 'title' => 'Keep tags'])
        ->assertJsonPath('result.structuredContent.post.tags', ['new-tag', 'another-tag']);

    $this->callPostTool('update-post', ['id' => $post->id, 'tags' => []])
        ->assertJsonPath('result.structuredContent.post.tags', []);
});

it('can delete a post', function () {
    $post = Post::factory()->create();

    Sanctum::actingAs($this->admin);

    $this->callPostTool('delete-post', ['id' => $post->id])
        ->assertJsonPath('result.isError', true);

    $this->assertDatabaseHas('posts', ['id' => $post->id]);

    $this->callPostTool('delete-post', ['id' => $post->id, 'confirm' => true])
        ->assertSuccessful()
        ->assertJsonPath('result.structuredContent.deleted_post_id', $post->id);

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

it('supports current protocol discovery with authenticated requests', function () {
    Sanctum::actingAs($this->admin);

    $this->postJson('/mcp/posts', [
        'jsonrpc' => '2.0', 'id' => 1, 'method' => 'server/discover',
        'params' => ['_meta' => [
            'io.modelcontextprotocol/protocolVersion' => '2026-07-28',
            'io.modelcontextprotocol/clientCapabilities' => (object) [],
        ]],
    ], [
        'MCP-Protocol-Version' => '2026-07-28',
        'MCP-Method' => 'server/discover',
    ])->assertSuccessful()->assertJsonPath('result.supportedVersions.0', '2026-07-28')
        ->assertJsonPath('result.instructions', fn (string $instructions) => str_contains($instructions, 'shared_tweet_url'));
});

it('requires authentication for discovery and every tool', function (string $method, array $params) {
    $this->postJson('/mcp/posts', ['jsonrpc' => '2.0', 'id' => 1, 'method' => $method, 'params' => $params])
        ->assertUnauthorized();
})->with([
    ['initialize', []],
    ['tools/list', []],
    ['tools/call', ['name' => 'create-post']],
    ['tools/call', ['name' => 'get-post']],
    ['tools/call', ['name' => 'update-post']],
    ['tools/call', ['name' => 'delete-post']],
]);

it('rejects revoked tokens and non-admin bearer tokens', function (bool $admin) {
    $user = User::factory()->create(['admin' => $admin]);
    $token = $user->createToken('ai-tool');

    if ($admin) {
        $token->accessToken->delete();
    }

    $response = $this->withToken($token->plainTextToken)->callPostTool('list-posts');

    $admin ? $response->assertUnauthorized() : $response->assertForbidden();
})->with([true, false]);

it('filters tags and paginates deterministically', function () {
    $posts = Post::factory()->count(3)->create(['publish_date' => now()]);
    $posts->each(fn (Post $post) => $post->syncTags(['laravel']));
    Post::factory()->create(['publish_date' => now()]);

    Sanctum::actingAs($this->admin);

    $this->callPostTool('list-posts', ['tag' => 'laravel', 'per_page' => 2, 'page' => 2])
        ->assertJsonCount(1, 'result.structuredContent.posts')
        ->assertJsonPath('result.structuredContent.posts.0.id', $posts->first()->id)
        ->assertJsonPath('result.structuredContent.current_page', 2)
        ->assertJsonPath('result.structuredContent.last_page', 2)
        ->assertJsonPath('result.structuredContent.total', 3);
});

it('reports unknown IDs and invalid pagination as tool errors', function () {
    Sanctum::actingAs($this->admin);

    foreach (['get-post', 'update-post', 'delete-post'] as $tool) {
        $this->callPostTool($tool, ['id' => 999999, 'confirm' => true])
            ->assertSuccessful()->assertJsonPath('result.isError', true);
    }

    foreach ([['per_page' => 51], ['page' => 0]] as $arguments) {
        $this->callPostTool('list-posts', $arguments)->assertJsonPath('result.isError', true);
    }
});

it('can schedule and explicitly publish a post', function () {
    Sanctum::actingAs($this->admin);
    $date = now()->addDays(2)->startOfSecond()->toIso8601String();

    $response = $this->callPostTool('create-post', [
        'title' => 'Scheduled article', 'text' => 'An article.', 'publish_date' => $date,
    ])->assertJsonPath('result.structuredContent.post.published', false)
        ->assertJsonPath('result.structuredContent.post.publish_date', $date);

    $id = $response->json('result.structuredContent.post.id');

    $this->callPostTool('update-post', ['id' => $id, 'published' => true])
        ->assertJsonPath('result.structuredContent.post.published', true);

    expect(Post::findOrFail($id)->published)->toBeTrue();
});

it('no longer serves the post REST endpoints', function (string $method, string $url) {
    Sanctum::actingAs($this->admin);

    $this->json($method, $url)->assertNotFound();
})->with([
    ['GET', '/api/posts'],
    ['GET', '/api/posts/1'],
    ['POST', '/api/posts'],
    ['PUT', '/api/posts/1'],
    ['PATCH', '/api/posts/1'],
    ['DELETE', '/api/posts/1'],
]);
