@if ($paginator->hasPages())
    <nav class="flex justify-between items-center pt-8">
        @if ($paginator->onFirstPage())
            <span class="text-sm text-gray-300">&larr; Newer</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="text-sm text-gray-600 hover:text-black transition-colors">&larr; Newer</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="text-sm text-gray-600 hover:text-black transition-colors">Older &rarr;</a>
        @else
            <span class="text-sm text-gray-300">Older &rarr;</span>
        @endif
    </nav>
@endif
