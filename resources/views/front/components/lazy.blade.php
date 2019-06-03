@if($usesInternetExplorer)
    {{ $slot }}
@else
    <div data-lazy>
        <template>
            {{ $slot }}
        </template>
    </div>
@endif
