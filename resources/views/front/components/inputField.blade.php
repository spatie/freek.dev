@props([
    'label',
    'name',
    'type' => 'text',
    'required' => true,
    'placeholder' => '',
    'wireModel' => null,  // New prop for Livewire support
])

<div class="mt-4">
    <label class="block">
        <span class="text-gray-700">{{ $label }}</span>
        <input
            id="{{ $name }}"
            type="{{ $type }}"
            class="form-input mt-1 block w-full"
            name="{{ $name }}"
            @if($wireModel)
                wire:model="{{ $wireModel }}"
            @else
                value="{{ old($name) }}"
            @endif
            {{ ($required) ? 'required' : '' }}
            autocomplete="{{ $name }}"
            placeholder="{{ $placeholder }}"
        >
    </label>
    <x-form-error :name="$wireModel ?? $name" />
</div>
