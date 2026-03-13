<div class="mb-12 md:mb-24 -mx-4 sm:mx-0 p-4 sm:p-6 bg-gray-50 border-b-3 border-gray-200">
    <p class="text-[11px] font-medium uppercase tracking-widest text-gray-400 mb-4">Worth reading</p>
    <ul class="space-y-4">
        @foreach($links as $link)
            <li>
                <a
                    href="{{ $link->external_url ?: $link->url }}"
                    @if($link->external_url) target="_blank" rel="noopener noreferrer" @endif
                    class="group"
                >
                    <p class="font-semibold leading-snug group-hover:text-gray-600 transition-colors">{{ $link->title }}</p>
                </a>
                <p class="text-sm text-gray-500 mt-0.5">
                    <a href="{{ $link->url }}">{{ $link->publish_date->format('M jS') }}</a>
                    @if($link->external_url)
                        · <a href="{{ $link->external_url }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-gray-600 transition-colors">{{ $link->external_url_host }}</a>
                    @endif
                </p>
                @if($link->excerpt)
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed line-clamp-2">{!! strip_tags($link->excerpt) !!}</p>
                @endif
            </li>
        @endforeach
    </ul>
</div>
