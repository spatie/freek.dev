@if ($paginator->hasPages())
    <ul class="pagination flex justify-between pt-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="button opacity-50"><span>@lang('pagination.previous')</span></li>
        @else
            <li class="button"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="button"><a href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a></li>
        @else
            <li class="button opacity-50"><span>@lang('pagination.next')</span></li>
        @endif
    </ul>
@endif
