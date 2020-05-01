<x-app-layout title="Originals">
    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
