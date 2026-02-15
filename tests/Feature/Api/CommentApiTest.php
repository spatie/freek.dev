<?php

use App\Models\Comment;
use App\Models\Commenter;
use App\Models\Post;
use Illuminate\Support\Str;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

function createCommenterWithToken(): array
{
    $plainToken = 'test-token-'.Str::random(32);

    $commenter = Commenter::factory()->create([
        'token' => hash('sha256', $plainToken),
    ]);

    return [$commenter, $plainToken];
}

it('lists comments for a post', function () {
    $post = Post::factory()->create();
    $comments = Comment::factory()->count(3)->create(['post_id' => $post->id]);

    getJson("/api/posts/{$post->id}/comments")
        ->assertOk()
        ->assertJsonCount(3, 'comments')
        ->assertJsonStructure([
            'comments' => [['id', 'body_html', 'created_at', 'commenter', 'reactions']],
            'post_reactions',
        ]);
});

it('returns comments in chronological order', function () {
    $post = Post::factory()->create();

    $first = Comment::factory()->create(['post_id' => $post->id, 'created_at' => now()->subHour()]);
    $second = Comment::factory()->create(['post_id' => $post->id, 'created_at' => now()]);

    getJson("/api/posts/{$post->id}/comments")
        ->assertOk()
        ->assertJsonPath('comments.0.id', $first->id)
        ->assertJsonPath('comments.1.id', $second->id);
});

it('creates a comment when authenticated', function () {
    [$commenter, $token] = createCommenterWithToken();
    $post = Post::factory()->create();

    postJson("/api/posts/{$post->id}/comments", ['body' => 'Hello **world**'], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertCreated()
        ->assertJsonPath('commenter.id', $commenter->id);

    expect($post->comments)->toHaveCount(1);
    expect($post->comments->first()->body)->toBe('Hello **world**');
    expect($post->comments->first()->body_html)->toContain('<strong>world</strong>');
});

it('rejects comment creation without auth', function () {
    $post = Post::factory()->create();

    postJson("/api/posts/{$post->id}/comments", ['body' => 'Hello'])
        ->assertUnauthorized();
});

it('validates comment body is required', function () {
    [$commenter, $token] = createCommenterWithToken();
    $post = Post::factory()->create();

    postJson("/api/posts/{$post->id}/comments", ['body' => ''], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertUnprocessable();
});

it('validates comment body max length', function () {
    [$commenter, $token] = createCommenterWithToken();
    $post = Post::factory()->create();

    postJson("/api/posts/{$post->id}/comments", ['body' => str_repeat('a', 10001)], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertUnprocessable();
});

it('allows owner to delete their comment', function () {
    [$commenter, $token] = createCommenterWithToken();
    $comment = Comment::factory()->create(['commenter_id' => $commenter->id]);

    deleteJson("/api/comments/{$comment->id}", [], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertNoContent();

    expect(Comment::find($comment->id))->toBeNull();
});

it('allows admin to delete any comment', function () {
    [$admin, $token] = createCommenterWithToken();
    $admin->update(['is_admin' => true]);

    $comment = Comment::factory()->create();

    deleteJson("/api/comments/{$comment->id}", [], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertNoContent();
});

it('forbids non-owner non-admin from deleting comment', function () {
    [$commenter, $token] = createCommenterWithToken();
    $comment = Comment::factory()->create();

    deleteJson("/api/comments/{$comment->id}", [], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertForbidden();
});

it('strips html from markdown comment body', function () {
    [$commenter, $token] = createCommenterWithToken();
    $post = Post::factory()->create();

    postJson("/api/posts/{$post->id}/comments", ['body' => '<script>alert("xss")</script>Hello'], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertCreated();

    $comment = $post->comments()->first();
    expect($comment->body_html)->not->toContain('<script>');
});
