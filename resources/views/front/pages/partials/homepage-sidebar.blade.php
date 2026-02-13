<div class="lg:sticky lg:top-8 lg:self-start space-y-8">
    <p class="text-[13px] leading-relaxed text-gray-400">
        I'm Freek Van der Herten. I maintain 300+ open source packages downloaded over 500 million times. I write about Laravel, PHP, and AI.
    </p>

    @if($topTags->isNotEmpty())
        <div>
            <h2 class="text-[11px] font-medium uppercase tracking-widest text-gray-400 mb-4">
                Browse by category
            </h2>
            <div class="flex flex-wrap gap-1.5">
                @foreach($topTags as $tag)
                    <a
                        wire:navigate.hover
                        href="{{ route('taggedPosts.index', $tag->slug) }}"
                        class="bg-gray-50 rounded-md px-2.5 py-1 text-[13px] text-gray-500 hover:bg-gray-100 hover:text-black transition-colors"
                    >
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <x-ad/>

    @if($popularPosts->isNotEmpty())
        <div>
            <h2 class="text-[11px] font-medium uppercase tracking-widest text-gray-400 mb-4">
                Popular content
            </h2>
            <ul class="space-y-2.5">
                @foreach($popularPosts as $popularPost)
                    <li>
                        <a
                            wire:navigate.hover
                            href="{{ $popularPost->url }}"
                            class="text-[13px] leading-snug text-gray-600 hover:text-black transition-colors"
                        >
                            {{ $popularPost->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <p class="mt-4">
                <a wire:navigate.hover href="{{ route('originals') }}" class="text-[12px] text-gray-400 hover:text-black transition-colors">
                    Browse all originals &rarr;
                </a>
            </p>
        </div>
    @endif
</div>
