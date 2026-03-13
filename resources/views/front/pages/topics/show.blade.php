<x-app-layout :title="$tag->name">
    <x-slot:sidebarTop>
        <div class="space-y-4">
            <p class="text-[13px] leading-relaxed text-gray-400">
                {{ $originalCount }} {{ Str::plural('article', $originalCount) }} and {{ $totalCount - $originalCount }} curated {{ Str::plural('link', $totalCount - $originalCount) }} about <strong class="text-gray-500">{{ $tag->name }}</strong>.
            </p>
            @if($relatedTags->isNotEmpty())
                <div>
                    <p class="text-[11px] font-medium uppercase tracking-widest text-gray-400 mb-2">Related topics</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($relatedTags as $relatedTag)
                            <a href="{{ route('topics.show', $relatedTag->slug) }}"
                               class="bg-gray-50 rounded-md px-2.5 py-1 text-[13px] text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                                {{ $relatedTag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </x-slot:sidebarTop>

    <div class="mb-8">
        <h2 class="text-2xl md:text-3xl font-extrabold mb-1">{{ $tag->name }}</h2>
        <p class="text-sm text-gray-500">
            {{ $originalCount }} {{ Str::plural('article', $originalCount) }} · {{ $totalCount }} total {{ Str::plural('post', $totalCount) }}
        </p>
    </div>

    @if($featuredPosts->isNotEmpty())
        <div class="mb-12">
            <h3 class="text-[11px] font-medium uppercase tracking-widest text-gray-400 mb-4">Featured articles</h3>
            <div class="space-y-4">
                @foreach($featuredPosts as $featured)
                    <a href="{{ $featured->url }}" class="block group">
                        <div class="border-l-4 pl-4 py-1" style="border-color: {{ $featured->theme }}">
                            <p class="font-semibold group-hover:text-gray-600 transition-colors">{{ $featured->title }}</p>
                            <p class="text-sm text-gray-500">{{ $featured->publish_date->format('M jS Y') }} · {{ $featured->reading_time }} min read</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <h3 class="text-[11px] font-medium uppercase tracking-widest text-gray-400 mb-4">All posts</h3>

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
