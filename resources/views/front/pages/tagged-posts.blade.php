<x-app-layout title="Posts tagged with '{{ $tag->name }}'">
    <div
        class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 mb-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700">

        <p>
            All posts tagged with <strong>{{ $tag->name }}</strong>.
        </p>
    </div>

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
