<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

class PostTagger implements Agent, HasStructuredOutput
{
    use Promptable;

    public function __construct(
        private readonly string $existingTags,
    ) {}

    public function instructions(): Stringable|string
    {
        return <<<PROMPT
            You are a blog post tagger. Given a blog post, return 1 to 5 relevant tags.

            Existing tags in the database: {$this->existingTags}

            Rules:
            - Strongly prefer tags from the existing list above.
            - Only suggest a new tag if none of the existing tags are a good fit.
            - Do NOT include the tag "tweet" — that tag is reserved for a special post type.
            - All tags must be lowercase.
            - If content is laravel related, include the "laravel" tag.
            - If content is php related, include the "php" tag.
            - If content is about AI, LLMs, machine learning, or related topics, include the "ai" tag.
            - If the post is about a Spatie package (e.g. spatie/laravel-*, spatie/*, or mentions Spatie as the author), include the "spatie" tag.
            - Never use version numbers in tags. Use "php" not "php8", "laravel" not "laravel11", etc. If a post currently has a versioned tag like "php8", replace it with "php".
            PROMPT;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'tags' => $schema->array()->items($schema->string())->required(),
        ];
    }
}
