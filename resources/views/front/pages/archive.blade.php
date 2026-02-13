<x-app-layout title="Archive">
    <div
        class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 mb-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700">

        <p>
            All blog posts, organized by year and month.
        </p>
    </div>

    @foreach($posts as $year => $months)
        <h2 class="font-extrabold text-2xl leading-tight mb-4 text-black">{{ $year }}</h2>

        @foreach($months as $month => $monthPosts)
            <h3 class="font-bold text-lg text-gray-700 mb-2 mt-4">{{ $month }}</h3>

            <ul class="space-y-2 mb-6">
                @foreach($monthPosts as $post)
                    <li class="flex items-baseline gap-2">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 mt-1.5" style="background-color: {{ $post->theme }}"></span>
                        <div>
                            <a wire:navigate.hover href="{{ $post->url }}" class="font-semibold text-black hover:underline">
                                {{ $post->title }}
                            </a>
                            <span class="text-xs text-gray-500 ml-1">{{ $post->publish_date->format('M j') }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endforeach
    @endforeach
</x-app-layout>
