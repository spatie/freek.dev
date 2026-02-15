<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreCommentRequest;
use App\Http\Resources\Api\CommentResource;
use App\Mail\NewCommentMail;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CommentController
{
    public function index(Post $post): JsonResponse
    {
        $post->load('reactions');

        $comments = $post->comments()
            ->with('commenter', 'reactions')
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'comments' => CommentResource::collection($comments),
            'post_reactions' => $post->groupedReactions(),
        ]);
    }

    public function store(StoreCommentRequest $request, Post $post): JsonResponse
    {
        $commenter = $request->commenter();
        $body = $request->input('body');

        $comment = $post->comments()->create([
            'commenter_id' => $commenter->id,
            'body' => $body,
            'body_html' => Str::markdown($body, ['html_input' => 'strip']),
        ]);

        $comment->setRelation('commenter', $commenter);

        Mail::to('freek@spatie.be')->queue(new NewCommentMail($comment, $post));

        return CommentResource::make($comment)
            ->response()
            ->setStatusCode(201);
    }

    public function destroy(Request $request, Comment $comment): JsonResponse
    {
        $commenter = $request->attributes->get('commenter');

        if ($comment->commenter_id !== $commenter->id && ! $commenter->is_admin) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $comment->delete();

        return response()->json(null, 204);
    }
}
