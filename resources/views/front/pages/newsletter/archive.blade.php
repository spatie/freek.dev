<x-app-layout title="Newsletter archive">

    <div class="mb-6">
        <h1 class="text-3xl font-extrabold leading-tight text-balance">Newsletter archive</h1>
        <p class="mt-3 text-[16px] leading-[26px] text-gray-600">
            Every monthly edition since 2019: the best Laravel, PHP and AI links I came across, plus what I've been building at Spatie and Oh Dear.
        </p>
    </div>

    <section aria-labelledby="quick-signup-heading" class="p-4 sm:p-5 bg-yellow-50 border-b-5 border-yellow-200">
        <h2 id="quick-signup-heading" class="text-[16px] leading-6 font-bold">Get the next one in your inbox</h2>
        <p class="mt-0.5 mb-3 text-[14px] leading-[21px] text-gray-500">One e-mail a month, read by 9,500+ developers.</p>
        @include('front.newsletter.partials.form', ['id' => 'archive-email'])
    </section>

    <div class="mt-10 space-y-8">
        @forelse($campaignsByYear as $year => $campaigns)
            <section aria-labelledby="year-{{ $year }}" class="grid grid-cols-[44px_minmax(0,1fr)] sm:grid-cols-[64px_minmax(0,1fr)] border-t border-gray-200">
                <h2 id="year-{{ $year }}" class="sticky top-0 self-start bg-white pt-[8px] text-[14px] leading-[22px] font-bold tabular-nums">{{ $year }}</h2>
                <ul class="min-w-0 divide-y divide-gray-100">
                    @foreach($campaigns as $campaign)
                        <li>
                            <a href="{{ $campaign->url }}" class="group grid grid-cols-[32px_minmax(0,1fr)_44px] sm:grid-cols-[40px_minmax(0,1fr)_52px] items-baseline gap-2 sm:gap-2.5 py-[8px] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900">
                                <span class="text-[13px] text-gray-500 tabular-nums">#{{ $campaign->edition_number }}</span>
                                <span class="text-[15px] leading-[22px] font-medium text-gray-900 group-hover:text-black group-hover:underline decoration-gray-300 underline-offset-3 break-words">{{ $campaign->name }}</span>
                                <time datetime="{{ $campaign->sent_at->toDateString() }}" class="text-[13px] text-gray-500 text-right tabular-nums whitespace-nowrap">{{ $campaign->sent_at->format('M j') }}</time>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @empty
            <p class="text-sm text-gray-600">Past editions will appear here. Subscribe to get the next one in your inbox.</p>
        @endforelse
    </div>

    <div class="mt-14">
        @include('front.newsletter.partials.block')
    </div>
</x-app-layout>
