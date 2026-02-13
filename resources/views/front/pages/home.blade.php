<x-app-layout>
    <x-ad/>

    @if($posts->onFirstPage())
        <p class="text-sm text-gray-600 mb-8">
            I'm Freek Van der Herten. I maintain 300+ open source packages downloaded over 500 million times. I write about Laravel, PHP, and AI.
        </p>
    @endif

    @include('front.posts.partials.list')

    {{ $posts->links() }}
</x-app-layout>
