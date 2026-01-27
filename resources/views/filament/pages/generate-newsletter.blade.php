<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            About the Newsletter
        </x-slot>

        <p class="text-sm text-gray-600 dark:text-gray-400">
            The newsletter includes:
        </p>
        <ul class="mt-2 text-sm text-gray-600 dark:text-gray-400 list-disc list-inside space-y-1">
            <li>Recent blog posts since the last newsletter</li>
            <li>Community submitted links</li>
            <li>Posts from about a year ago</li>
        </ul>
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            Click "Generate Newsletter" to create a new campaign in Mailcoach.
        </p>
    </x-filament::section>

    @if($this->generatedEditionNumber)
        <x-filament::section>
            <x-slot name="heading">
                Newsletter Generated
            </x-slot>

            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Edition:</span>
                    <span class="text-sm text-gray-900 dark:text-white">#{{ $this->generatedEditionNumber }}</span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Date range:</span>
                    <span class="text-sm text-gray-900 dark:text-white">
                        {{ $this->generatedStartDate }} - {{ $this->generatedEndDate }}
                    </span>
                </div>
                <div class="pt-2">
                    <x-filament::button
                        tag="a"
                        :href="$this->generatedMailcoachUrl"
                        target="_blank"
                        icon="heroicon-o-arrow-top-right-on-square"
                    >
                        Open in Mailcoach
                    </x-filament::button>
                </div>
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>
