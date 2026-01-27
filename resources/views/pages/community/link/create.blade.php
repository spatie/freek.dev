<?php

use function Laravel\Folio\{middleware, name};

middleware(['auth', 'verified', 'doNotCacheResponse']);
name('community.link.create');

?>

<x-app-layout title="Submit a link" xmlns="http://www.w3.org/1999/html">

    <div class="markup mb-8">
        <h1>Submit a link</h1>

        <div
            class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-gray-100 border-b-5 border-gray-200 text-sm text-gray-700 markup">
            After you submitted a link, I need a little time to check it out. If I think it's something my
            audience is interested in, I'll publish it, and you'll get notified via mail.
        </div>

        <livewire:link-form />
    </div>
</x-app-layout>
