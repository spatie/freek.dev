<x-filament-widgets::widget class="fi-wi-table mb-6">
    <div class="flex items-center justify-between gap-x-3 px-4 pt-4 sm:px-6">
        <h3 class="fi-section-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
            Most Popular Posts
        </h3>

        <x-filament::input.wrapper
            inline-prefix
            wire:target="days"
        >
            <x-filament::input.select
                inline-prefix
                wire:model.live="days"
            >
                @foreach ($this->getFilters() as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>
    </div>

    {{ $this->table }}
</x-filament-widgets::widget>
