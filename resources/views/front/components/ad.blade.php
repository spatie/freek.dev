@if($ad)
<div data-no-index class="bg-gray-50 rounded-md px-4 py-3 text-[13px] leading-relaxed text-gray-400 [&_p+p]:mt-2 [&_a]:text-gray-500 [&_a]:underline [&_a]:decoration-gray-300 [&_a:hover]:text-black [&_a:hover]:decoration-black [&_a]:transition-colors">
    {!! $ad->html !!}
</div>
@endif
