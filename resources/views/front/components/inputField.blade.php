@props([
    'label',
    'name',
    'type' => 'text',
    'required' => true,
    'placeholder' => '',
    'wireModel' => null,
])

<div class="mb-5">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $label }}</label>
    <input
        id="{{ $name }}"
        type="{{ $type }}"
        class="block w-full rounded-md border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-colors focus:border-gray-400 focus:outline-none focus:ring-0"
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
    <x-form-error :name="$wireModel ?? $name" />
</div>
