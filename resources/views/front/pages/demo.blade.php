<x-app-layout title="Demo">
    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
