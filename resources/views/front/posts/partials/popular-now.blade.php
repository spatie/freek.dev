@php
    $popularPosts = app(\App\Services\PopularPostsService::class)->getPopularPosts();
@endphp

@if($popularPosts->isNotEmpty())
    <div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700 mb-8">
        <p class="font-extrabold text-2xl leading-tight mb-4 text-black">
            Popular this month
        </p>
        <ul class="space-y-3">
            @foreach($popularPosts as $popularPost)
                <li class="flex items-baseline gap-2">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 mt-1.5" style="background-color: {{ $popularPost->theme }}"></span>
                    <div>
                        <a wire:navigate.hover href="{{ $popularPost->url }}" class="font-semibold text-black hover:underline">
                            {{ $popularPost->title }}
                        </a>
                        <span class="text-xs text-gray-500 ml-1">{{ $popularPost->reading_time }} min read</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
