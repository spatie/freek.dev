@php
    $relatedPosts = $post->getRelatedPosts();
@endphp

@if($relatedPosts->isNotEmpty())
    <div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700 mb-8">
        <p class="font-extrabold text-2xl leading-tight mb-4 text-black">
            Related posts
        </p>
        <ul class="space-y-3">
            @foreach($relatedPosts as $relatedPost)
                <li class="flex items-baseline gap-2">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 mt-1.5" style="background-color: {{ $relatedPost->theme }}"></span>
                    <div>
                        <a href="{{ $relatedPost->url }}" class="font-semibold text-black hover:underline">
                            {{ $relatedPost->title }}
                        </a>
                        <span class="text-xs text-gray-500 ml-1">{{ $relatedPost->reading_time }} min read</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
