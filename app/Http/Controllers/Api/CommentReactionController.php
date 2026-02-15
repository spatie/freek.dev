<?php

namespace App\Http\Controllers\Api;

use App\Enums\Emoji;
use App\Models\Comment;
use App\Models\Commenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CommentReactionController
{
    public function __invoke(Request $request, Comment $comment): JsonResponse
    {
        $request->validate([
            'emoji' => ['required', 'string', new Enum(Emoji::class)],
        ]);

        /** @var Commenter $commenter */
        $commenter = $request->attributes->get('commenter');

        $toggled = $comment->toggleReaction($commenter->id, $request->input('emoji'));

        return response()->json(['toggled' => $toggled]);
    }
}
