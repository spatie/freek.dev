<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Commenter;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommentController
{
    public function index(Post $post): JsonResponse
    {
        $comments = $post->comments()
            ->with('commenter', 'reactions')
            ->orderBy('created_at')
            ->get()
            ->map(fn (Comment $comment) => [
                'id' => $comment->id,
                'body_html' => $comment->body_html,
                'created_at' => $comment->created_at->toIso8601String(),
                'commenter' => [
                    'id' => $comment->commenter->id,
                    'username' => $comment->commenter->username,
                    'name' => $comment->commenter->name,
                    'avatar_url' => $comment->commenter->avatar_url,
                ],
                'reactions' => $this->groupReactions($comment),
            ]);

        $postReactions = $this->groupReactions($post);

        return response()->json([
            'comments' => $comments,
            'post_reactions' => $postReactions,
        ]);
    }

    public function store(Request $request, Post $post): JsonResponse
    {
        $request->validate([
            'body' => ['required', 'string', 'max:10000'],
        ]);

        /** @var Commenter $commenter */
        $commenter = $request->attributes->get('commenter');

        $body = $request->input('body');

        $comment = $post->comments()->create([
            'commenter_id' => $commenter->id,
            'body' => $body,
            'body_html' => Str::markdown($body, ['html_input' => 'strip']),
        ]);

        $comment->load('commenter');

        return response()->json([
            'id' => $comment->id,
            'body_html' => $comment->body_html,
            'created_at' => $comment->created_at->toIso8601String(),
            'commenter' => [
                'id' => $commenter->id,
                'username' => $commenter->username,
                'name' => $commenter->name,
                'avatar_url' => $commenter->avatar_url,
            ],
            'reactions' => [],
        ], 201);
    }

    public function destroy(Request $request, Comment $comment): JsonResponse
    {
        /** @var Commenter $commenter */
        $commenter = $request->attributes->get('commenter');

        if ($comment->commenter_id !== $commenter->id && ! $commenter->is_admin) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $comment->delete();

        return response()->json(null, 204);
    }

    /** @return array<string, array{count: int, commenter_ids: int[]}> */
    private function groupReactions(Post|Comment $model): array
    {
        $grouped = [];

        foreach ($model->reactions as $reaction) {
            if (! isset($grouped[$reaction->emoji])) {
                $grouped[$reaction->emoji] = ['count' => 0, 'commenter_ids' => []];
            }

            $grouped[$reaction->emoji]['count']++;
            $grouped[$reaction->emoji]['commenter_ids'][] = $reaction->commenter_id;
        }

        return $grouped;
    }
}
