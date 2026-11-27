<li class="list-none min-w-0">
    <img
        class="w-full aspect-square object-cover ring-1 ring-black/10"
        src="{{ Storage::disk('uploads')->url('media/music/'.$release['artwork']) }}"
        alt="{{ $release['title'] }} artwork"
        width="360"
        height="360"
    >
    <h3 class="mt-2 text-sm font-bold leading-tight">{{ $release['title'] }}</h3>
    <div class="mt-1 flex flex-wrap gap-x-3 text-[13px] leading-relaxed">
        @foreach($release['links'] as $label => $url)
            <a class="link" href="{{ $url }}">{{ $label }}</a>
        @endforeach
    </div>
</li>
