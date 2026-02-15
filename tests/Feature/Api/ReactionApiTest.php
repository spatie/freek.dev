<?php

use App\Models\Comment;
use App\Models\Commenter;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Support\Str;

use function Pest\Laravel\postJson;

function createAuthenticatedCommenter(): array
{
    $plainToken = 'test-token-'.Str::random(32);

    $commenter = Commenter::factory()->create([
        'token' => hash('sha256', $plainToken),
    ]);

    return [$commenter, $plainToken];
}

it('toggles a reaction on a post', function () {
    [$commenter, $token] = createAuthenticatedCommenter();
    $post = Post::factory()->create();

    postJson("/api/posts/{$post->id}/reactions", ['emoji' => '👍'], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertOk()
        ->assertJsonPath('toggled', true);

    expect(Reaction::count())->toBe(1);

    postJson("/api/posts/{$post->id}/reactions", ['emoji' => '👍'], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertOk()
        ->assertJsonPath('toggled', false);

    expect(Reaction::count())->toBe(0);
});

it('toggles a reaction on a comment', function () {
    [$commenter, $token] = createAuthenticatedCommenter();
    $comment = Comment::factory()->create();

    postJson("/api/comments/{$comment->id}/reactions", ['emoji' => '❤️'], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertOk()
        ->assertJsonPath('toggled', true);

    expect($comment->reactions()->count())->toBe(1);

    postJson("/api/comments/{$comment->id}/reactions", ['emoji' => '❤️'], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertOk()
        ->assertJsonPath('toggled', false);

    expect($comment->reactions()->count())->toBe(0);
});

it('rejects invalid emoji', function () {
    [$commenter, $token] = createAuthenticatedCommenter();
    $post = Post::factory()->create();

    postJson("/api/posts/{$post->id}/reactions", ['emoji' => '💀'], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertUnprocessable();
});

it('requires authentication to react', function () {
    $post = Post::factory()->create();

    postJson("/api/posts/{$post->id}/reactions", ['emoji' => '👍'])
        ->assertUnauthorized();
});

it('allows multiple different emojis on same post', function () {
    [$commenter, $token] = createAuthenticatedCommenter();
    $post = Post::factory()->create();

    postJson("/api/posts/{$post->id}/reactions", ['emoji' => '👍'], [
        'Authorization' => "Bearer {$token}",
    ])->assertOk();

    postJson("/api/posts/{$post->id}/reactions", ['emoji' => '🚀'], [
        'Authorization' => "Bearer {$token}",
    ])->assertOk();

    expect(Reaction::count())->toBe(2);
});

it('includes reaction data in comment list', function () {
    [$commenter, $token] = createAuthenticatedCommenter();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create(['post_id' => $post->id]);

    Reaction::factory()->create([
        'commenter_id' => $commenter->id,
        'reactable_type' => $comment->getMorphClass(),
        'reactable_id' => $comment->id,
        'emoji' => '👍',
    ]);

    Reaction::factory()->create([
        'commenter_id' => $commenter->id,
        'reactable_type' => $post->getMorphClass(),
        'reactable_id' => $post->id,
        'emoji' => '🚀',
    ]);

    $this->getJson("/api/posts/{$post->id}/comments")
        ->assertOk()
        ->assertJsonPath('comments.0.reactions.👍.count', 1)
        ->assertJsonPath('post_reactions.🚀.count', 1);
});
