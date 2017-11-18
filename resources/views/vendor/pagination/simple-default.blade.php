@if ($paginator->hasPages())
    <ul class="pagination flex justify-between pt-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><span class="button opacity-50">@lang('pagination.previous')</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="button hover:text-white">@lang('pagination.previous')</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="button hover:text-white">@lang('pagination.next')</a></li>
        @else
            <li><span class="button opacity-50">@lang('pagination.next')</span></li>
        @endif
    </ul>
@endif
