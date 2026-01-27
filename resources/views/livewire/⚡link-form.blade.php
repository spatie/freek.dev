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

<form wire:submit.prevent="save">
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

    <div class="mt-4">
        <label class="text-gray-700">
            <span class="text-gray-700">Description</span>
            <textarea
                wire:model="form.text"
                placeholder="Describe the content in one or two sentences. You can use markdown."
            ></textarea>
        </label>
        <x-form-error name="form.text" />
    </div>

    <div class="mt-4">
        <x-submit-button label="Submit link"/>
    </div>
</form>
