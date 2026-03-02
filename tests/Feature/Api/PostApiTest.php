<?php

use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('returns 401 for unauthenticated requests', function () {
    $this->getJson('/api/posts')->assertUnauthorized();
});

it('returns 403 for non-admin users', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->getJson('/api/posts')->assertForbidden();
});

it('returns 200 for admin users', function () {
    Sanctum::actingAs($this->admin);

    $this->getJson('/api/posts')->assertSuccessful();
});

it('can list posts', function () {
    Post::factory()->count(3)->create();

    Sanctum::actingAs($this->admin);

    $this->getJson('/api/posts')
        ->assertSuccessful()
        ->assertJsonCount(3, 'data');
});

it('can filter posts by published status', function () {
    Post::factory()->create(['published' => true]);
    Post::factory()->create(['published' => false]);

    Sanctum::actingAs($this->admin);

    $this->getJson('/api/posts?published=1')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.published', true);
});

it('can filter posts by original content', function () {
    Post::factory()->create(['original_content' => true]);
    Post::factory()->create(['original_content' => false]);

    Sanctum::actingAs($this->admin);

    $this->getJson('/api/posts?original_content=1')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.original_content', true);
});

it('can search posts by title', function () {
    Post::factory()->create(['title' => 'Laravel tips and tricks']);
    Post::factory()->create(['title' => 'PHP best practices']);

    Sanctum::actingAs($this->admin);

    $this->getJson('/api/posts?search=Laravel')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.title', 'Laravel tips and tricks');
});

it('can show a single post', function () {
    $post = Post::factory()->create();

    Sanctum::actingAs($this->admin);

    $this->getJson("/api/posts/{$post->id}")
        ->assertSuccessful()
        ->assertJsonPath('data.id', $post->id)
        ->assertJsonPath('data.title', $post->title);
});

it('can create a post', function () {
    Sanctum::actingAs($this->admin);

    $this->postJson('/api/posts', [
        'title' => 'A new blog post',
        'text' => 'Some content for the post.',
        'published' => false,
    ])
        ->assertCreated()
        ->assertJsonPath('data.title', 'A new blog post');

    $this->assertDatabaseHas('posts', [
        'title' => 'A new blog post',
        'text' => 'Some content for the post.',
    ]);
});

it('can create a post with tags', function () {
    Sanctum::actingAs($this->admin);

    $this->postJson('/api/posts', [
        'title' => 'Tagged post',
        'text' => 'Content with tags.',
        'tags' => ['laravel', 'php'],
    ])
        ->assertCreated()
        ->assertJsonPath('data.tags', ['laravel', 'php']);
});

it('validates required fields on store', function () {
    Sanctum::actingAs($this->admin);

    $this->postJson('/api/posts', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['title', 'text']);
});

it('can update a post', function () {
    $post = Post::factory()->create();

    Sanctum::actingAs($this->admin);

    $this->putJson("/api/posts/{$post->id}", [
        'title' => 'Updated title',
    ])
        ->assertSuccessful()
        ->assertJsonPath('data.title', 'Updated title');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated title',
    ]);
});

it('can update post tags', function () {
    $post = Post::factory()->create();
    $post->syncTags(['old-tag']);

    Sanctum::actingAs($this->admin);

    $this->putJson("/api/posts/{$post->id}", [
        'tags' => ['new-tag', 'another-tag'],
    ])
        ->assertSuccessful()
        ->assertJsonPath('data.tags', ['new-tag', 'another-tag']);
});

it('can delete a post', function () {
    $post = Post::factory()->create();

    Sanctum::actingAs($this->admin);

    $this->deleteJson("/api/posts/{$post->id}")
        ->assertNoContent();

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});
