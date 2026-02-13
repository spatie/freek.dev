<?php

use Livewire\Component;
use App\Livewire\Forms\LinkForm;

new class extends Component {
    public LinkForm $form;

    public function save(): void
    {
        $this->form->validate();
        $this->form->store();

        $this->redirect('/community/thanks', true);
    }
}; ?>

<form wire:submit.prevent="save" class="max-w-sm">
    <x-input-field
        label="Title"
        name="title"
        wire-model="form.title"
    />

    <x-input-field
        label="URL"
        name="url"
        wire-model="form.url"
        placeholder="https://"
    />

    <div class="mb-5">
        <label for="text" class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
        <textarea
            id="text"
            wire:model="form.text"
            rows="3"
            class="block w-full rounded-md border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-colors focus:border-gray-400 focus:outline-none focus:ring-0"
            placeholder="Describe the content in one or two sentences. You can use markdown."
        ></textarea>
        <x-form-error name="form.text" />
    </div>

    <x-submit-button label="Submit link"/>
</form>
