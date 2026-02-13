@php
    $relatedPosts = $post->getRelatedPosts();
    $popularPosts = app(\App\Services\PopularPostsService::class)->getPopularPosts();

    $relatedIds = $relatedPosts->pluck('id')->all();
    $dedupedPopular = $popularPosts->reject(fn ($p) => in_array($p->id, $relatedIds) || $p->id === $post->id);

    $keepReading = $relatedPosts
        ->merge($dedupedPopular)
        ->take(5);
@endphp

@if($keepReading->isNotEmpty())
    <div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700 mb-8">
        <p class="font-extrabold text-2xl leading-tight mb-4 text-black">
            Keep reading
        </p>
        <ul class="space-y-3">
            @foreach($keepReading as $keepReadingPost)
                <li class="flex items-baseline gap-2">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 mt-1.5" style="background-color: {{ $keepReadingPost->theme }}"></span>
                    <div>
                        <a wire:navigate.hover href="{{ $keepReadingPost->url }}" class="font-semibold text-black hover:underline">
                            {{ $keepReadingPost->title }}
                        </a>
                        <span class="text-xs text-gray-500 ml-1">{{ $keepReadingPost->reading_time }} min read</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
