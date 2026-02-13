<x-app-layout title="Posts tagged with '{{ $tag->name }}'">
    <x-slot:sidebarTop>
        <p class="text-[13px] leading-relaxed text-gray-400">
            All posts tagged with <strong class="text-gray-500">{{ $tag->name }}</strong>.
        </p>
    </x-slot:sidebarTop>

    <p class="min-[1140px]:hidden text-sm text-gray-400 mb-8">
        Posts tagged with <strong class="text-gray-500">{{ $tag->name }}</strong>
    </p>

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
