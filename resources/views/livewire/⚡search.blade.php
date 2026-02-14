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

        $postTitles = Post::query()
            ->whereIn('id', $postIds)
            ->pluck('title', 'id');

        return [
            'hits' => $hits,
            'postTitles' => $postTitles,
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
    <input wire:model.live="query"
           type="text"
           autofocus
           placeholder="Search 2000+ posts…"
           class="form-input mt-1 block w-full mb-4"
    />

    @if ($query !== '')
        @if (count($hits))
            <ul>
                @foreach($hits as $hit)
                    @php
                        $path = ltrim(parse_url($hit->url, PHP_URL_PATH) ?? '', '/');
                        $postId = preg_match('/^(\d+)-/', $path, $m) ? (int) $m[1] : null;
                        $title = $postId ? ($postTitles[$postId] ?? null) : null;
                        $title ??= $hit->entry ? \Illuminate\Support\Str::limit(strip_tags($hit->entry), 80) : $hit->url;
                    @endphp
                    <li wire:key="{{ $hit->id }}" class="mb-6">
                        <a href="{{ $hit->url }}">
                            <div class="font-bold leading-tight hover:underline">{{ $title }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mt-2 text-gray-700">Nothing here…</p>
        @endif
    @endif
</div>
