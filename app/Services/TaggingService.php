<?php

namespace App\Services;

use App\Models\Post;
use OpenAI\Laravel\Facades\OpenAI;
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

        $input = $post->title . "\n\n" . strip_tags($post->text);
        $input = mb_substr($input, 0, 8000);

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => <<<PROMPT
                        You are a blog post tagger. Given a blog post, return 1 to 5 relevant tags as a JSON array of lowercase strings.

                        Existing tags in the database: {$existingTags}

                        Rules:
                        - Strongly prefer tags from the existing list above.
                        - Only suggest a new tag if none of the existing tags are a good fit.
                        - Return only a JSON array of strings, nothing else. Example: ["php", "laravel", "testing"]
                        - Do NOT include the tag "tweet" — that tag is reserved for a special post type.
                        PROMPT,
                ],
                [
                    'role' => 'user',
                    'content' => $input,
                ],
            ],
            'temperature' => 0.3,
        ]);

        $content = trim($response->choices[0]->message->content);

        $tags = json_decode($content, true);

        if (! is_array($tags)) {
            return [];
        }

        return collect($tags)
            ->map(fn (string $tag) => strtolower(trim($tag)))
            ->filter()
            ->take(5)
            ->values()
            ->all();
    }
}
