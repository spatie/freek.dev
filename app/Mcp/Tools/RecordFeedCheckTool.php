<?php

namespace App\Mcp\Tools;

use App\Models\MonitoredFeed;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;

#[Name('record-feed-check')]
#[Description('Persist fetched RSS/Atom items as seen and return new_items to announce. Pass the original GUID/Atom ID (or link if absent), link and publication date, not modification date. Deduplicates by exact ID or URL per source and suppresses dates at/before its fixed baseline. First success without a baseline silently seeds all submitted items; empty successes do not initialize. Submit up to 500 items per call, newest batch first for initial seeding. On fetch failure send error instead of items; history and baseline are preserved. Repeating a successful call returns no new_items: inspect saved history if the result is uncertain. This tool neither fetches nor sends notifications.')]
#[IsDestructive]
class RecordFeedCheckTool extends Tool
{
    public function handle(Request $request): ResponseFactory
    {
        $data = $request->validate([
            'feed_id' => ['required', 'integer', 'exists:monitored_feeds,id'],
            'error' => [Rule::requiredIf(! array_key_exists('items', $request->all())), 'prohibits:items', 'string', 'max:4000'],
            'items' => [Rule::when(! array_key_exists('error', $request->all()), ['present']), 'prohibits:error', 'array', 'max:500'],
            'items.*' => ['array:identifier,url,title,published_at'],
            'items.*.identifier' => ['required', 'string', 'max:4096'],
            'items.*.url' => ['required', 'url:http,https', 'max:4096'],
            'items.*.title' => ['nullable', 'string', 'max:4096'],
            'items.*.published_at' => ['nullable', 'date_format:Y-m-d\TH:i:sP'],
        ]);

        return (new MonitoredFeed)->getConnection()->transaction(function () use ($data): ResponseFactory {
            $feed = MonitoredFeed::whereKey($data['feed_id'])->lockForUpdate()->firstOrFail();
            $checkedAt = now();

            if (isset($data['error'])) {
                $feed->update(['last_checked_at' => $checkedAt, 'last_error' => $data['error']]);

                return Response::structured(['feed' => $feed->toArray(), 'new_items' => []]);
            }

            $initializing = $feed->baseline_before === null;
            $newItems = [];

            foreach ($data['items'] as $item) {
                $identifierHash = hash('sha256', $item['identifier']);
                $urlHash = hash('sha256', $item['url']);
                $known = $feed->seenItems()->where(function ($query) use ($identifierHash, $urlHash) {
                    $query->where('identifier_hash', $identifierHash)->orWhere('url_hash', $urlHash);
                })->exists();

                if ($known) {
                    continue;
                }

                $publishedAt = isset($item['published_at']) ? Carbon::parse($item['published_at'])->setTimezone(config('app.timezone')) : null;
                $saved = $feed->seenItems()->create([
                    ...$item,
                    'published_at' => $publishedAt,
                    'identifier_hash' => $identifierHash,
                    'url_hash' => $urlHash,
                    'seen_at' => $checkedAt,
                ]);

                if (! $initializing && ($publishedAt === null || $publishedAt->gt($feed->baseline_before))) {
                    $newItems[] = $saved->toArray();
                }
            }

            if ($initializing && count($data['items']) > 0) {
                $feed->baseline_before = $checkedAt;
            }

            $feed->fill(['last_checked_at' => $checkedAt, 'last_error' => null])->save();

            return Response::structured(['feed' => $feed->toArray(), 'initialized' => $initializing && $feed->baseline_before !== null, 'new_items' => $newItems]);
        });
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'feed_id' => $schema->integer()->min(1)->required(),
            'error' => $schema->string()->max(4000)->description('Fetch/parse failure. Omit items when sending an error.'),
            'items' => $schema->array()->max(500)->items($schema->object([
                'identifier' => $schema->string()->max(4096)->required(),
                'url' => $schema->string()->max(4096)->required(),
                'title' => $schema->string()->max(4096)->nullable(),
                'published_at' => $schema->string()->nullable()->description('ISO 8601 publication time with timezone, not modified time. Null if unavailable.'),
            ])->withoutAdditionalProperties())->description('Fetched items. [] records an empty successful fetch without establishing a baseline. Omit on error.'),
        ];
    }
}
