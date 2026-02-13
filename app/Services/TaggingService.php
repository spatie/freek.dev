<?php

namespace App\Services;

use App\Models\Post;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\Prism;
use Prism\Prism\Schema\ArraySchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
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

        $response = Prism::structured()
            ->using(Provider::Anthropic, 'claude-haiku-4-5-20251001')
            ->usingTemperature(0)
            ->withSchema(new ObjectSchema(
                name: 'tags',
                description: 'Tags for the blog post',
                properties: [
                    new ArraySchema(
                        name: 'tags',
                        description: 'List of 1 to 5 relevant tags, lowercased',
                        items: new StringSchema('tag', 'A single tag'),
                    ),
                ],
                requiredFields: ['tags'],
            ))
            ->withSystemPrompt(<<<PROMPT
                You are a blog post tagger. Given a blog post, return 1 to 5 relevant tags.

                Existing tags in the database: {$existingTags}

                Rules:
                - Strongly prefer tags from the existing list above.
                - Only suggest a new tag if none of the existing tags are a good fit.
                - Do NOT include the tag "tweet" — that tag is reserved for a special post type.
                - All tags must be lowercase.
                - If content is laravel related, include the "laravel" tag.
                - If content is php related, include the "php" tag.
                - If content is about AI, LLMs, machine learning, or related topics, include the "ai" tag.
                - Never use version numbers in tags. Use "php" not "php8", "laravel" not "laravel11", etc. If a post currently has a versioned tag like "php8", replace it with "php".
                PROMPT)
            ->withPrompt($input)
            ->asStructured();

        $tags = $response->structured['tags'] ?? [];

        return collect($tags)
            ->map(fn (string $tag) => strtolower(trim($tag)))
            ->filter()
            ->take(5)
            ->values()
            ->all();
    }
}
