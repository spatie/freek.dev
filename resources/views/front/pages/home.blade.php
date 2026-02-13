<x-app-layout :wide="true">
    @if($posts->onFirstPage())
        <div class="xl:grid xl:grid-cols-[1fr_280px] xl:gap-12">
            <div class="min-w-0">
                @include('front.posts.partials.list')

                {{ $posts->links() }}
            </div>

            <aside class="hidden xl:block">
                @include('front.pages.partials.homepage-sidebar')
            </aside>
        </div>
    @else
        @include('front.posts.partials.list')

        {{ $posts->links() }}
    @endif
</x-app-layout>
