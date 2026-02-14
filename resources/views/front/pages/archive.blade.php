<x-app-layout title="Archive">

    @foreach($posts as $year => $months)
        <h2 class="font-extrabold text-4xl leading-tight text-black sticky top-0 bg-white py-3 z-20 border-b border-gray-100">{{ $year }}</h2>

        @foreach($months as $month => $monthPosts)
            <h3 class="font-bold text-sm uppercase tracking-wider text-gray-400 sticky top-[4rem] bg-white py-2 z-10">{{ $month }}</h3>

            <ul class="mb-8 ml-4 border-l border-gray-200">
                @foreach($monthPosts as $post)
                    <li class="relative pl-6 py-1.5 group">
                        <span class="absolute left-[-3.5px] top-[13px] w-1.5 h-1.5 rounded-full bg-gray-300 ring-2 ring-white group-hover:bg-gray-500 transition-colors"></span>
                        <a wire:navigate.hover href="{{ $post->url }}" class="font-medium text-gray-900 group-hover:text-black transition-colors">
                            {{ $post->title }}
                        </a>
                        @if($post->isOriginal())
                            <span class="text-[10px] font-medium text-gray-400 border border-gray-200 rounded-full px-1.5 py-0.5 align-middle ml-0.5">original</span>
                        @endif
                        <span class="text-xs text-gray-400 ml-1.5 tabular-nums whitespace-nowrap">{{ $post->publish_date->format('M j') }}</span>
                    </li>
                @endforeach
            </ul>
        @endforeach
    @endforeach
</x-app-layout>
