<x-app-layout :wide="true">
    @if($posts->onFirstPage())
        <div class="min-[1140px]:grid min-[1140px]:grid-cols-[minmax(0,560px)_220px] min-[1140px]:gap-12">
            <div class="min-w-0 max-w-[560px]">
                @include('front.posts.partials.list')

                {{ $posts->links() }}
            </div>

            <aside class="hidden min-[1140px]:block">
                @include('front.pages.partials.homepage-sidebar')
            </aside>
        </div>
    @else
        @include('front.posts.partials.list')

        {{ $posts->links() }}
    @endif
</x-app-layout>
