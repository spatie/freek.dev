<x-app-layout>
    <x-ad />

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
