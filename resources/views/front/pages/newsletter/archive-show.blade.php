<x-app-layout title="{{ $newsletterCampaign->name }}">

    <x-slot name="seo">
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{ $newsletterCampaign->name }}">
        <meta property="article:published_time" content="{{ $newsletterCampaign->sent_at->toIso8601String() }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ $newsletterCampaign->name }}">
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('newsletter.archive.index') }}" class="text-sm text-gray-400 hover:text-black transition-colors">&larr; Newsletter Archive</a>
    </div>

    <div class="mb-8 -mx-4 sm:mx-0 p-4 sm:p-6 bg-yellow-50 border-b-5 border-yellow-200 text-sm text-gray-700">
        <p class="text-gray-600 mb-3">
            You're reading edition #{{ $newsletterCampaign->edition_number }} from {{ $newsletterCampaign->sent_at->format('F Y') }}. Want the next one in your inbox?
        </p>
        @include('front.newsletter.partials.form')
    </div>

    <div class="mb-8">
        @include('front.newsletter.partials.email-card', ['campaign' => $newsletterCampaign])
    </div>

    <div class="mt-12">
        @include('front.newsletter.partials.block')
    </div>
</x-app-layout>
