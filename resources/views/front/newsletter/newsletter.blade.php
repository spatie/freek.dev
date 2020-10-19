<x-app-layout title="{{ $campaign->subject }}">
    @include('front.newsletter.partials.block')

    {!! $campaign->webview_html !!}
</x-app-layout>
