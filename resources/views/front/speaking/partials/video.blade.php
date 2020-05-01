<article class="p-4 -mx-4 sm:mx-0 sm:p-6 m bg-gray-100 border-b-5 border-gray-200 mb-6">
    <h3 class="h3 | mt-0 mb-4">{{ $video->title }}</h3>
    <div class="md:flex text-sm">
        <div class="markup | mb-5 md:mb-0 md:w-1/3 md:pr-4">
            <x-lazy>
                {!! str_replace('width="560" height="315"', '', $video->embed) !!}
            </x-lazy>
        </div>
        <div class="flex-1">
            <div class="markup">
                {!! $video->formatted_text !!}
            </div>
        </div>
    </div>
</article>
