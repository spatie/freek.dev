<div class="mt-4">
    <label class="text-gray-700" for="{{ $name }}">
        <span class="text-gray-700">{{ $label }}</span>
        <textarea
            placeholder="{{ $placeholder ?? '' }}"
            class="form-textarea mt-1 block w-full"
            name="{{ $name }}"
            type="text"
            required>{{ old($name) }}</textarea>
    </label>
    @error($name)
    <div
        class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
    @enderror
</div>
