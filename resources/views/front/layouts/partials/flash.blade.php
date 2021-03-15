@if(flash()->message)
    <div
        class="text-white font-bold bg-green-400 {{ flash()->class }}  p-2 text-center"
        x-data="{show: true}"
        x-show.transition.duration.1000ms="show"

        x-init="setTimeout(() => show = false, 8000)"
    >
        {{ flash()->message }}
    </div>
@endif
