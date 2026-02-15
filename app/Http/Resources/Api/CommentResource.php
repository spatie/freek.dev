<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public static $wrap = null;

    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body_html' => $this->body_html,
            'created_at' => $this->created_at->toIso8601String(),
            'commenter' => new CommenterResource($this->commenter),
            'reactions' => $this->groupedReactions(),
        ];
    }
}
