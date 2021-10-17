<div>
    <input wire:model="query"
           type="text"
           autofocus
           placeholder="Laravel, PHP, JavaScript,…"
           class="form-input mt-1 block w-full mb-4"
    >

    @if ($query === 'greece woods')
        🌳 We love you Greece! 🇬🇷
    @else
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
    @endif
</div>
