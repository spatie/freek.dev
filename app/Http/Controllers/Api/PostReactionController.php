<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ToggleReactionRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostReactionController
{
    public function __invoke(ToggleReactionRequest $request, Post $post): JsonResponse
    {
        $toggled = $post->toggleReaction(
            $request->commenter()->id,
            $request->input('emoji'),
        );

        return response()->json(['toggled' => $toggled]);
    }
}
