<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Post */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'text' => $this->text,
            'html' => $this->html,
            'publish_date' => $this->publish_date?->toIso8601String(),
            'published' => $this->published,
            'original_content' => $this->original_content,
            'external_url' => $this->external_url,
            'series_slug' => $this->series_slug,
            'author_twitter_handle' => $this->author_twitter_handle,
            'send_automated_tweet' => $this->send_automated_tweet,
            'tags' => $this->tags->pluck('name')->values()->all(),
            'url' => $this->url,
            'preview_url' => $this->preview_url,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
