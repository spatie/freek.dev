<div>
    <input wire:model="query"
           type="text"
           autofocus
           placeholder="Laravel, PHP, JavaScript,…"
           class="form-input mt-1 block w-full"
    >

    @if ($query === 'greece woods')
        🌳 We love you Greece! 🇬🇷
    @else
        @if ($query !== '')
            @if (count($results))
                <ul>
                    @foreach($results as $post)
                        <li class="mb-6">
                            <strong class="text-lg">
                                <a href={{ $post->url }}>{{ $post->title }}</a>
                            </strong>
                            <br/>
                            <a href="{{ $post->url }}" class="text-sm text-gray-700">
                                {{ $post->formatted_type }} - {{ $post->publish_date->format('M jS Y') }}
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
