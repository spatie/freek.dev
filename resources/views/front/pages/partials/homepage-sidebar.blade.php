<div class="sticky top-8 self-start space-y-8">
    <p class="text-[13px] leading-relaxed text-gray-400">
        I'm a Laravel developer at <a href="https://spatie.be" target="_blank" class="text-gray-500 hover:text-black transition-colors underline decoration-gray-300 hover:decoration-black">Spatie</a> and <a href="https://ohdear.app" target="_blank" class="text-gray-500 hover:text-black transition-colors underline decoration-gray-300 hover:decoration-black">Oh Dear</a>. I maintain <a href="https://spatie.be/open-source" target="_blank" class="text-gray-500 hover:text-black transition-colors underline decoration-gray-300 hover:decoration-black">300+ open source packages</a> for the Laravel community.
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
