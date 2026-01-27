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
    <x-form-error :name="$name" />
</div>
