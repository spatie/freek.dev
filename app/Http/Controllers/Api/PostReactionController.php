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

        $existing = $post->reactions()
            ->where('commenter_id', $commenter->id)
            ->where('emoji', $request->input('emoji'))
            ->first();

        if ($existing) {
            $existing->delete();

            return response()->json(['toggled' => false]);
        }

        $post->reactions()->create([
            'commenter_id' => $commenter->id,
            'emoji' => $request->input('emoji'),
        ]);

        return response()->json(['toggled' => true]);
    }
}
