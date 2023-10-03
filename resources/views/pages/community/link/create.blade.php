<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\LinkForm;
use function Livewire\Volt\{form};
use function Laravel\Folio\{middleware, name};

middleware(['auth', 'verified', 'doNotCacheResponse']);
name('community.link.create');

form(LinkForm::class);

$save = function () {
    $this->form->validate();
    $this->form->store();

    $this->redirect('/community/thanks', true);
}; ?>

<x-app-layout title="Submit a link" xmlns="http://www.w3.org/1999/html">

    <div class="markup mb-8">
        <h1>Submit a link</h1>

        <div
            class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700 markup">
            After you submitted a link, I need a little time to check it out. If I think it's something my
            audience is interested in, I'll publish it, and you'll get notified via mail.
        </div>

        @volt('linkForm')

        <form wire:submit.prevent="save">
            <div class="mt-4">
                <label class="block">
                    <span class="text-gray-700">Title</span>
                    <input
                        type="text"
                        wire:model="form.title"
                        class="form-input mt-1 block w-full"
                    />
                </label>
                @error('form.title')
                <div
                    class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <label class="block">
                    <span class="text-gray-700">URL</span>
                    <input
                        type="text"
                        wire:model="form.url"
                        placeholder="https://"
                        class="form-input mt-1 block w-full"
                    />
                </label>
                @error('form.url')
                <div
                    class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <label class="text-gray-700" for="Description">
                    <span class="text-gray-700">Description</span>
                    <textarea
                        type="text"
                        wire:model="form.text"
                        placeholder="Describe the content in one or two sentences. You can use markdown."
                    ></textarea>
                </label>
                @error('form.text')
                <div
                    class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <x-submit-button label="Submit link"/>
            </div>
        </form>
        @endvolt
    </div>
</x-app-layout>
