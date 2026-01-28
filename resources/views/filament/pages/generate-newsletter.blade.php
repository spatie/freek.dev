<x-filament-panels::page>
    <div class="grid gap-6 md:grid-cols-2">
        <x-filament::section>
            <x-slot name="heading">
                About the Newsletter
            </x-slot>

            <div class="prose prose-sm dark:prose-invert max-w-none">
                <p>The newsletter includes:</p>
                <ul>
                    <li>Recent blog posts since the last newsletter</li>
                    <li>Community submitted links</li>
                    <li>Posts from about a year ago</li>
                </ul>
            </div>
        </x-filament::section>

        @if($this->generatedEditionNumber)
            <x-filament::section icon="heroicon-o-check-circle" icon-color="success">
                <x-slot name="heading">
                    Newsletter #{{ $this->generatedEditionNumber }}
                </x-slot>

                <div class="space-y-4">
                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400">From</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $this->generatedStartDate }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400">To</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $this->generatedEndDate }}</dd>
                        </div>
                    </dl>

                    <x-filament::button
                        tag="a"
                        :href="$this->generatedMailcoachUrl"
                        target="_blank"
                        icon="heroicon-o-arrow-top-right-on-square"
                    >
                        Open in Mailcoach
                    </x-filament::button>
                </div>
            </x-filament::section>
        @else
            <x-filament::section icon="heroicon-o-envelope">
                <x-slot name="heading">
                    Ready to Generate
                </x-slot>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Click the "Generate Newsletter" button to create a new campaign in Mailcoach.
                </p>
            </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>
