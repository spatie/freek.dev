@props([
    'label',
    'name',
    'type' => 'text',
    'required' => true,
    'placeholder' => ''
])

<div class="mt-4">
    <label class="block">
        <span class="text-gray-700">{{ $label }}</span>
        <input
            id="{{ $name }}"
            type="{{ $type }}"
            class="form-input mt-1 block w-full"
            name="{{ $name }}"
            value="{{ old($name) }}"
            {{ ($required) ? 'required' : '' }}
            autocomplete="{{ $name }}"
            placeholder="{{ $placeholder }}"
        >
    </label>
    @error($name)
    <div
        class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
    @enderror
    <div>


    </div>
</div>
