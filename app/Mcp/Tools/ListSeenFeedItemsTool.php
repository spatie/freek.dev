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

#[Name('list-seen-feed-items')]
#[Description('Read paginated already-seen item identities, URLs, titles, publication dates, and seen dates for one private source. The feed baseline also covers older history not individually stored. record-feed-check deduplicates fetched items against both the baseline and stored identities/URLs; there is no need to download all history before a check.')]
#[IsReadOnly]
class ListSeenFeedItemsTool extends Tool
{
    public function handle(Request $request): ResponseFactory
    {
        $data = $request->validate([
            'feed_id' => ['required', 'integer', 'exists:monitored_feeds,id'],
            'page' => ['integer', 'min:1'],
            'per_page' => ['integer', 'min:1', 'max:100'],
        ]);

        $items = MonitoredFeed::findOrFail($data['feed_id'])->seenItems()->latest('id')
            ->paginate($data['per_page'] ?? 50, page: $data['page'] ?? 1);

        return Response::structured([
            'items' => $items->items(),
            'current_page' => $items->currentPage(),
            'last_page' => $items->lastPage(),
            'total' => $items->total(),
        ]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'feed_id' => $schema->integer()->min(1)->required(),
            'page' => $schema->integer()->min(1),
            'per_page' => $schema->integer()->min(1)->max(100),
        ];
    }
}
