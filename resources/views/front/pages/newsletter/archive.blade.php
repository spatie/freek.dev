<x-app-layout title="Newsletter Archive">

    <div class="markup mb-8">
        <h1>Newsletter Archive</h1>
        <p>
            Browse all past editions of the freek.dev newsletter.
        </p>
    </div>

    @foreach($campaignsByYear as $year => $campaigns)
        <div class="mb-16">
            <h2 class="font-extrabold text-4xl leading-tight text-black text-center sticky top-0 bg-white z-20 py-4 mb-4">{{ $year }}</h2>

            <ul class="mb-8 ml-4 border-l border-gray-200">
                @foreach($campaigns as $campaign)
                    <li class="relative pl-6 py-1.5 group">
                        <span class="absolute left-[-3.5px] top-[13px] w-1.5 h-1.5 rounded-full bg-gray-300 ring-2 ring-white group-hover:bg-gray-500 transition-colors"></span>
                        <a href="{{ $campaign->url }}" class="font-medium text-gray-900 group-hover:text-black transition-colors">
                            {{ $campaign->name }}
                        </a>
                        <span class="text-xs text-gray-400 ml-1.5 tabular-nums whitespace-nowrap">{{ $campaign->sent_at->format('M j') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    <div class="mt-8">
        @include('front.newsletter.partials.block')
    </div>
</x-app-layout>
