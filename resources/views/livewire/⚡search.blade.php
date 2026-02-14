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
        $hits = $this->getResults();

        $postIds = collect($hits)
            ->map(fn ($hit) => $this->extractPostId($hit->url))
            ->filter()
            ->unique()
            ->values();

        $posts = Post::query()
            ->select('id', 'title', 'original_content', 'publish_date')
            ->with('tags:id,name,slug')
            ->whereIn('id', $postIds)
            ->get()
            ->keyBy('id');

        return [
            'hits' => $hits,
            'posts' => $posts,
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
        @if ($posts->isNotEmpty())
            <ul>
                @foreach($hits as $hit)
                    @php
                        $path = ltrim(parse_url($hit->url, PHP_URL_PATH) ?? '', '/');
                        $postId = preg_match('/^(\d+)-/', $path, $m) ? (int) $m[1] : null;
                        $post = $postId ? ($posts[$postId] ?? null) : null;
                    @endphp
                    @continue(! $post)
                    <li wire:key="{{ $hit->id }}" class="mb-5 pb-5 border-b border-gray-100 last:border-0">
                        <a wire:navigate.hover href="{{ $hit->url }}" class="font-bold leading-tight hover:underline">
                            {{ $post->title }}
                        </a>
                        @if($post?->isOriginal())
                            <span class="text-[10px] font-medium text-gray-400 border border-gray-200 rounded-full px-1.5 py-0.5 align-middle ml-0.5">original</span>
                        @endif
                        @if($post?->publish_date)
                            <span class="text-xs text-gray-400 ml-1.5 tabular-nums whitespace-nowrap">{{ $post->publish_date->format('M j, Y') }}</span>
                        @endif
                        @if($post?->tags->isNotEmpty())
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @foreach($post->tags->sortBy->name as $tag)
                                    <a wire:navigate.hover href="{{ route('taggedPosts.index', $tag->slug) }}"
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
