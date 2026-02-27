<div class="rounded-lg border border-gray-200 shadow-sm overflow-hidden">
    <div class="bg-gray-50 px-4 sm:px-6 py-4 border-b border-gray-200 text-[13px] leading-relaxed">
        <div class="grid grid-cols-[3.5rem_1fr] gap-y-0.5">
            <span class="text-gray-400">From</span>
            <span class="text-gray-600">Freek Van der Herten &lt;freek@spatie.be&gt;</span>
            <span class="text-gray-400">Date</span>
            <span class="text-gray-600">{{ $campaign->sent_at->format('D, M j, Y \a\t g:i A') }}</span>
            <span class="text-gray-400">Subject</span>
            <span class="text-gray-900 font-medium">{{ $campaign->name }}</span>
        </div>
    </div>

    <div class="p-4 sm:p-6">
        <newsletter-content>
            <template shadowrootmode="open">
                <style>
                    :host { display: block; overflow: hidden; }
                    table, td, div { max-width: 100% !important; box-sizing: border-box !important; }
                    table[width], td[width] { width: auto !important; max-width: 100% !important; }
                    img { max-width: 100% !important; height: auto !important; }
                </style>
                {!! $campaign->web_view_html !!}
            </template>
        </newsletter-content>
    </div>
</div>
