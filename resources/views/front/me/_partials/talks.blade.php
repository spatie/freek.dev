<h2 id="talks">
    Talks
    <a class="text-grey" href="#talks">#</a>
</h2>

@foreach($talks as $talk)
    <li class="pb-6 pt-4 border-t list-reset">
        {{ $talk->title }}
        <div class="text-xs text-grey">
            {{ $talk->presented_at->format('M d, Y') }}
            &nbsp; • &nbsp; {{ $talk->location }}
            @if (! empty($talk->links))
                &nbsp; • &nbsp;  {!! $talk->links !!}
            @endif
        </div>
    </li>
@endforeach