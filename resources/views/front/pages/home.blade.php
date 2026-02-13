<x-app-layout :wide="true">
    @if($posts->onFirstPage())
        <div class="lg:grid lg:grid-cols-[1fr_280px] lg:gap-12">
            <div>
                @include('front.posts.partials.list')

                {{ $posts->links() }}
            </div>

            <aside class="hidden lg:block">
                @include('front.pages.partials.homepage-sidebar')
            </aside>
        </div>
    @else
        @include('front.posts.partials.list')

        {{ $posts->links() }}
    @endif
</x-app-layout>
