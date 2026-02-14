@if($previousPost || $nextPost)
    <div class="flex justify-between items-baseline text-sm text-gray-600 border-b border-gray-200 pb-8 mb-8">
        <div>
            @if($previousPost)
                <a href="{{ $previousPost->url }}" class="hover:text-black transition-colors">
                    &larr; {{ $previousPost->title }}
                </a>
            @endif
        </div>
        <div class="text-right">
            @if($nextPost)
                <a href="{{ $nextPost->url }}" class="hover:text-black transition-colors">
                    {{ $nextPost->title }} &rarr;
                </a>
            @endif
        </div>
    </div>
@endif
