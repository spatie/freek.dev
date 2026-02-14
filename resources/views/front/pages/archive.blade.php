<x-app-layout title="Archive {{ $year }}">

    <div x-data="{ yearHeight: 0 }" x-init="yearHeight = $refs.yearHeader.offsetHeight">
        <div class="sticky top-0 bg-white z-20 py-4 mb-4" x-ref="yearHeader">
            <h2 class="font-extrabold text-4xl leading-tight text-black text-center">{{ $year }}</h2>
        </div>

        @foreach($posts as $month => $monthPosts)
            <h3 class="font-bold text-sm uppercase tracking-wider text-gray-400 sticky bg-white py-2 z-10"
                :style="`top: ${yearHeight}px`">{{ $month }}</h3>

            <ul class="mb-8 ml-4 border-l border-gray-200">
                @foreach($monthPosts as $post)
                    <li class="relative pl-6 py-1.5 group">
                        <span class="absolute left-[-3.5px] top-[13px] w-1.5 h-1.5 rounded-full bg-gray-300 ring-2 ring-white group-hover:bg-gray-500 transition-colors"></span>
                        <a wire:navigate.hover href="{{ $post->url }}" class="font-medium text-gray-900 group-hover:text-black transition-colors">
                            {{ $post->title }}
                        </a>
                        @if($post->isOriginal())
                            <span class="text-xs font-medium text-gray-400 border border-gray-200 rounded-full px-2 py-0.5 align-middle ml-1">original</span>
                        @endif
                        <span class="text-xs text-gray-400 ml-1.5 tabular-nums whitespace-nowrap">{{ $post->publish_date->format('M j') }}</span>
                    </li>
                @endforeach
            </ul>
        @endforeach

        <div class="flex items-center justify-between mt-8 pt-8 border-t border-gray-100">
            <div>
                @if($nextYear)
                    <a wire:navigate.hover href="{{ route('archive', $nextYear) }}" class="text-sm text-gray-400 hover:text-black transition-colors">&larr; {{ $nextYear }}</a>
                @endif
            </div>
            <div>
                @if($previousYear)
                    <a wire:navigate.hover href="{{ route('archive', $previousYear) }}" class="text-sm text-gray-400 hover:text-black transition-colors">{{ $previousYear }} &rarr;</a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
