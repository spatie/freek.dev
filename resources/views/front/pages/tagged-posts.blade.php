<x-app-layout title="Posts tagged with '{{ $tag->name }}'">
    <x-slot:sidebarTop>
        <p class="text-[13px] leading-relaxed text-gray-400">
            All posts tagged with <strong class="text-gray-500">{{ $tag->name }}</strong>.
        </p>
    </x-slot:sidebarTop>

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
