@props(['label'])

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center rounded-md bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-black active:scale-[0.96] focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2 disabled:cursor-wait disabled:bg-gray-500 disabled:active:scale-100',
]) }}>{{ $label }}</button>
