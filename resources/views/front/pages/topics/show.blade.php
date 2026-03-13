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
        <h2 class="text-2xl md:text-3xl font-extrabold mb-2">{{ $tag->name }}</h2>
        <p class="text-gray-500 mb-3">All my posts about {{ $tag->name }}.</p>
        @if($relatedTags->isNotEmpty())
            <div class="flex flex-wrap gap-1.5">
                @foreach($relatedTags as $relatedTag)
                    <a href="{{ route('topics.show', $relatedTag->slug) }}"
                       class="bg-gray-50 rounded-md px-2.5 py-1 text-[13px] text-gray-500 hover:bg-gray-100 hover:text-black transition-colors">
                        {{ $relatedTag->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
