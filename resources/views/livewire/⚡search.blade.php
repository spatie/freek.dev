<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Url;
use Spatie\SiteSearch\Search;

new class extends Component {
    #[Url(except: '')]
    public string $query = '';

    public function with(): array
    {
        $seen = [];

        $hits = $this->getResults()->filter(function ($hit) use (&$seen) {
            $postId = $this->extractPostId($hit->url);

            if ($postId === null || in_array($postId, $seen)) {
                return false;
            }

            $seen[] = $postId;

            return true;
        })->values();

        $postIds = $hits->map(fn ($hit) => $this->extractPostId($hit->url));

        $posts = Post::query()
            ->select('id', 'title', 'original_content', 'publish_date')
            ->with('tags:id,name,slug')
            ->whereIn('id', $postIds)
            ->get()
            ->keyBy('id');

        $results = $hits
            ->map(fn ($hit) => [
                'url' => $hit->url,
                'id' => $hit->id,
                'post' => $posts[$this->extractPostId($hit->url)] ?? null,
            ])
            ->filter(fn ($result) => $result['post'] !== null)
            ->values();

        return [
            'results' => $results,
        ];
    }

    public function getResults()
    {
        if ($this->query === '') {
            return collect();
        }

        return Search::onIndex('freek')
            ->limit(40)
            ->query($this->query)
            ->get()
            ->hits;
    }

    private function extractPostId(string $url): ?int
    {
        $path = ltrim(parse_url($url, PHP_URL_PATH) ?? '', '/');

        if (preg_match('/^(\d+)-/', $path, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }
}; ?>

<div>
    <input wire:model.live.debounce.300ms="query"
           type="text"
           autofocus
           placeholder="Search 2000+ posts…"
           class="form-input mt-1 block w-full mb-4"
    />

    @if ($query !== '')
        @if ($results->isNotEmpty())
            <ul>
                @foreach($results as $result)
                    <li wire:key="{{ $result['id'] }}" class="mb-5 pb-5 border-b border-gray-100 last:border-0">
                        <a href="{{ $result['url'] }}" class="font-bold leading-tight hover:underline">
                            {{ $result['post']->title }}
                        </a>
                        @if($result['post']->isOriginal())
                            <span class="text-[10px] font-medium text-gray-400 border border-gray-200 rounded-full px-1.5 py-0.5 align-middle ml-0.5">original</span>
                        @endif
                        @if($result['post']->publish_date)
                            <span class="text-xs text-gray-400 ml-1.5 tabular-nums whitespace-nowrap">{{ $result['post']->publish_date->format('M j, Y') }}</span>
                        @endif
                        @if($result['post']->tags->isNotEmpty())
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @foreach($result['post']->tags->sortBy->name as $tag)
                                    <a href="{{ route('taggedPosts.index', $tag->slug) }}"
                                       class="bg-gray-50 rounded-md px-2 py-0.5 text-[12px] text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mt-2 text-gray-700">Nothing here…</p>
        @endif
    @endif
</div>
