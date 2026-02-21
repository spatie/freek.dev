<form wire:submit.prevent="save" class="max-w-sm">
    <div class="mb-5">
        <label for="text" class="block text-sm font-medium text-gray-700 mb-1.5">Why would you recommend this newsletter?</label>
        <textarea
            id="text"
            wire:model="form.text"
            rows="3"
            class="block w-full rounded-md border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-colors focus:border-gray-400 focus:outline-none focus:ring-0"
            placeholder="e.g. Practical Laravel tips I actually use in my day-to-day work. No fluff."
        ></textarea>
        <x-form-error name="form.text" />
    </div>

    <x-input-field
        label="Your name"
        name="author_name"
        wire-model="form.author_name"
        placeholder="Jane Doe"
    />

    <x-input-field
        label="Title / role"
        name="author_title"
        wire-model="form.author_title"
        :required="false"
        placeholder="Senior Developer at Acme"
    />

    <x-input-field
        label="Your website or profile"
        name="author_url"
        wire-model="form.author_url"
        :required="false"
        placeholder="https://x.com/you or https://your-site.com"
    />

    <div class="mb-5">
        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1.5">Photo</label>
        <label
            for="avatar"
            class="flex items-center gap-3 w-full rounded-md border border-gray-200 bg-white px-3 py-2.5 text-sm transition-colors cursor-pointer hover:border-gray-400"
        >
            @if($form->avatar && $form->avatar->isPreviewable())
                <img src="{{ $form->avatar->temporaryUrl() }}" alt="Preview" class="w-8 h-8 rounded-full object-cover">
                <span class="text-gray-700 truncate">{{ $form->avatar->getClientOriginalName() }}</span>
            @else
                <span class="text-gray-400">Choose a photo&hellip;</span>
            @endif
        </label>
        <input
            id="avatar"
            type="file"
            wire:model="form.avatar"
            accept="image/*"
            class="hidden"
        >
        <x-form-error name="form.avatar" />
    </div>

    <x-submit-button label="Submit recommendation"/>
</form>
