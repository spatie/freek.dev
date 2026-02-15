<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ToggleReactionRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentReactionController
{
    public function __invoke(ToggleReactionRequest $request, Comment $comment): JsonResponse
    {
        $toggled = $comment->toggleReaction(
            $request->commenter()->id,
            $request->input('emoji'),
        );

        return response()->json(['toggled' => $toggled]);
    }
}
