<?php

use Livewire\Component;
use Livewire\Attributes\Url;
use Spatie\SiteSearch\Search;

new class extends Component {
    #[Url(except: '')]
    public string $query = '';

    public function with(): array
    {
        return ['hits' => $this->getResults()];
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
}; ?>

<div>
    <input wire:model.live="query"
           type="text"
           autofocus
           placeholder="Laravel, PHP, JavaScript,…"
           class="form-input mt-1 block w-full mb-4"
    />

    @if ($query !== '')
        @if (count($hits))
            <ul>
                @foreach($hits as $hit)
                    <li wire:key="{{ $hit->id }}" class="mb-6">
                        <a href="{{ $hit->url }}">
                            <div class="font-bold leading-tight hover:underline">{{ $hit->title() }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mt-2 text-gray-700">Nothing here…</p>
        @endif
    @endif
</div>
