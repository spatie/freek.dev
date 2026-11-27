<x-app-layout title="Originals">
    <div class="originals">
        <p class="text-[16px] leading-normal text-gray-500 mb-5">
            In this section you can read posts I've written myself.
        </p>

        @include('front.posts.partials.list', ['originals' => true])

        {{ $posts->links() }}
    </div>
</x-app-layout>
