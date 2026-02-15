<?php

namespace App\Http\Controllers\Api;

use App\Enums\Emoji;
use App\Models\Commenter;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PostReactionController
{
    public function __invoke(Request $request, Post $post): JsonResponse
    {
        $request->validate([
            'emoji' => ['required', 'string', new Enum(Emoji::class)],
        ]);

        /** @var Commenter $commenter */
        $commenter = $request->attributes->get('commenter');

        $toggled = $post->toggleReaction($commenter->id, $request->input('emoji'));

        return response()->json(['toggled' => $toggled]);
    }
}
