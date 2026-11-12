<?php

namespace App\Mcp\Tools;

use App\Models\MonitoredFeed;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Name('list-monitored-feeds')]
#[Description('Read the private blog and podcast monitoring sources, including baseline cutoff, last check, errors, and seen-item counts. Omit enabled to include disabled sources. Fetch feeds outside this tool; record-feed-check stores the results. Never publish this private list.')]
#[IsReadOnly]
class ListMonitoredFeedsTool extends Tool
{
    public function handle(Request $request): ResponseFactory
    {
        $filters = $request->validate([
            'enabled' => ['boolean'],
            'type' => ['in:blog,podcast'],
        ]);

        return Response::structured([
            'feeds' => MonitoredFeed::query()->where($filters)->withCount('seenItems')->orderBy('id')->get()->toArray(),
        ]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'enabled' => $schema->boolean()->description('True for active sources; omit for all sources.'),
            'type' => $schema->string()->enum(['blog', 'podcast']),
        ];
    }
}
