<x-app-layout title="Topics">
    <div class="mb-8">
        <h2 class="text-2xl md:text-3xl font-extrabold mb-2">Topics</h2>
        <p class="text-gray-600 leading-relaxed">
            Over a decade of writing about Laravel, PHP, and modern web development. Browse by topic to find what you need.
        </p>
    </div>

    <div class="space-y-3">
        @foreach($topics as $topic)
            <a href="{{ route('topics.show', $topic->slug) }}" class="block group">
                <div class="flex items-baseline justify-between gap-4 py-3 border-b border-gray-100 group-hover:border-gray-300 transition-colors">
                    <div>
                        <span class="font-semibold text-lg group-hover:text-black transition-colors">{{ $topic->name }}</span>
                        @if($topic->original_count > 0)
                            <span class="text-sm text-gray-400 ml-2">{{ $topic->original_count }} {{ Str::plural('article', $topic->original_count) }}</span>
                        @endif
                    </div>
                    <span class="text-sm text-gray-400 shrink-0">{{ $topic->published_post_count }} {{ Str::plural('post', $topic->published_post_count) }}</span>
                </div>
            </a>
        @endforeach
    </div>
</x-app-layout>
