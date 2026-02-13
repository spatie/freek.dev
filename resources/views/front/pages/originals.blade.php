<x-app-layout title="Originals">
    <x-slot:sidebarTop>
        <p class="text-[13px] leading-relaxed text-gray-400">
            In this section you can read posts I've written myself.
        </p>
    </x-slot:sidebarTop>

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
