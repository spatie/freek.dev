<?php

namespace App\Services;

use App\Ai\Agents\PostTagger;
use App\Models\Post;
use Laravel\Ai\Enums\Lab;
use Spatie\Tags\Tag;

class TaggingService
{
    public function generateTags(Post $post): array
    {
        $existingTags = Tag::query()
            ->pluck('name')
            ->map(fn ($name) => is_array($name) ? ($name['en'] ?? reset($name)) : $name)
            ->unique()
            ->values()
            ->implode(', ');

        $input = $post->title."\n\n".strip_tags($post->text);
        $input = mb_substr($input, 0, 8000);

        $response = (new PostTagger($existingTags))->prompt(
            prompt: $input,
            provider: Lab::Anthropic,
            model: 'claude-haiku-4-5-20251001',
        );

        $tags = $response['tags'] ?? [];

        return collect($tags)
            ->map(fn (string $tag) => strtolower(trim($tag)))
            ->filter()
            ->take(5)
            ->values()
            ->all();
    }
}
