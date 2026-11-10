<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\CreatePostTool;
use App\Mcp\Tools\DeletePostTool;
use App\Mcp\Tools\GetPostTool;
use App\Mcp\Tools\ListPostsTool;
use App\Mcp\Tools\UpdatePostTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('freek.dev posts')]
#[Version('1.0.0')]
#[Instructions(<<<'TEXT'
    Manage blog posts, community links, and shared tweets on freek.dev.
    Use list-posts to find existing posts before creating or editing; get-post returns their full content and preview URL.
    To share a tweet, call create-post with a title and shared_tweet_url. The author and tweet text are imported from X; text is optional Markdown commentary, not the tweet itself. No tweet tag is needed.
    New posts are drafts by default. Set published=true only when the user asks to publish. To schedule, set published=false and publish_date to a future ISO 8601 timestamp with a timezone. A publish_date on an unpublished post schedules it, even if the date is in the past.
    Use update-post for changes, sending only changed fields; never create a replacement for an existing post. Confirm the intended post before permanent deletion.
    Website tweets use native X embeds. Saved tweet text is used in feeds and the Noteworthy tweets section of newsletters covering the publication date. These tools do not create or send newsletters or post tweets to X.
    TEXT)]
class PostsServer extends Server
{
    protected array $tools = [
        ListPostsTool::class,
        GetPostTool::class,
        CreatePostTool::class,
        UpdatePostTool::class,
        DeletePostTool::class,
    ];
}
