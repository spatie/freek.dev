@props(['name'])

@error($name)
<div class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">
    {{ $message }}
</div>
@enderror
