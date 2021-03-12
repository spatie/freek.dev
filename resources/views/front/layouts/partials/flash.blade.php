@if(flash()->message)
    <div class="{{ flash()->class }}">{{ flash()->message }}</div>
@endif

<div
    class="text-white font-bold bg-green-400 p-2 {{ flash()->class }} text-center"
    @click="console.log('hey')"
    x-data="{show: true}"
    x-show.transition.duration.1000ms="show"

    x-init="setTimeout(() => show = false, 8000)"
>
    here
</div>

