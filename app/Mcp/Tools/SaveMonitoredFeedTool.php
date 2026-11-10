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

#[Name('save-monitored-feed')]
#[Description('Create or update a private monitoring source. Supply id to edit, including URL corrections; omit id to upsert by exact URL. Omitted fields on updates are preserved. Disable with enabled=false rather than deleting history. baseline_before is creation-only: import the original UTC baseline cutoff to suppress historical backlog. Otherwise the first successful record-feed-check silently initializes the baseline. Does not fetch the URL or publish anything.')]
#[IsDestructive]
class SaveMonitoredFeedTool extends Tool
{
    public function handle(Request $request): Response|ResponseFactory
    {
        $input = $request->validate([
            'id' => ['integer', 'exists:monitored_feeds,id'],
            'url' => ['required_without:id', 'url:http,https', 'max:4096'],
        ]);

        $feed = isset($input['id'])
            ? MonitoredFeed::findOrFail($input['id'])
            : MonitoredFeed::firstOrNew(['url_hash' => hash('sha256', $input['url'])]);

        $data = $request->validate([
            'name' => [Rule::requiredIf(! $feed->exists), 'string', 'max:255'],
            'url' => ['url:http,https', 'max:4096'],
            'type' => [Rule::requiredIf(! $feed->exists), 'in:blog,podcast'],
            'enabled' => ['boolean'],
            'baseline_before' => [Rule::prohibitedIf($feed->exists), 'date_format:Y-m-d\TH:i:sP', 'before_or_equal:now'],
        ]);

        if (isset($data['url'])) {
            $data['url_hash'] = hash('sha256', $data['url']);

            if (MonitoredFeed::where('url_hash', $data['url_hash'])->where('id', '!=', $feed->id ?? 0)->exists()) {
                return Response::error('This URL already belongs to another monitored feed. Use list-monitored-feeds to find it.');
            }
        }

        if (isset($data['baseline_before'])) {
            $data['baseline_before'] = Carbon::parse($data['baseline_before'])->setTimezone(config('app.timezone'));
        }

        $feed->fill($data)->save();

        return Response::structured(['feed' => $feed->refresh()->toArray()]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->min(1)->description('Existing feed ID; omit to create or find by exact URL.'),
            'name' => $schema->string()->max(255)->description('Required for a new source.'),
            'url' => $schema->string()->max(4096)->description('HTTP(S) RSS or Atom URL. Required without id.'),
            'type' => $schema->string()->enum(['blog', 'podcast'])->description('Required for a new source.'),
            'enabled' => $schema->boolean()->description('Defaults to true on creation.'),
            'baseline_before' => $schema->string()->description('Creation-only ISO 8601 cutoff with timezone, e.g. 2026-01-02T09:00:00+00:00. Publication dates at or before this are already seen; omit for silent initialization on first success.'),
        ];
    }
}
