<x-app-layout :wide="true">
    @if($posts->onFirstPage())
        @if($featuredPosts->isNotEmpty())
            <div class="mb-12 md:mb-16">
                <h2 class="text-[11px] font-medium uppercase tracking-widest text-gray-400 mb-5">Latest articles</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($featuredPosts as $featured)
                        <a href="{{ $featured->url }}" class="group block">
                            <div class="h-full border-t-4 pt-4" style="border-color: {{ $featured->theme }}">
                                <h3 class="font-extrabold text-lg leading-tight mb-2 group-hover:text-gray-600 transition-colors">
                                    {{ $featured->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-3">
                                    {{ $featured->publish_date->format('M jS Y') }} · {{ $featured->reading_time }} min read
                                </p>
                                <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                                    {{ $featured->plain_text_excerpt }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="min-[1140px]:grid min-[1140px]:grid-cols-[minmax(0,560px)_220px] min-[1140px]:gap-12">
            <div class="min-w-0 max-w-[560px]">
                @include('front.posts.partials.list')

                {{ $posts->links() }}
            </div>

            <aside class="hidden min-[1140px]:block">
                @include('front.pages.partials.homepage-sidebar')
                <div class="sticky top-8 mt-8">
                    <x-ad/>
                </div>
            </aside>
        </div>
    @else
        @include('front.posts.partials.list')

        {{ $posts->links() }}
    @endif
</x-app-layout>
