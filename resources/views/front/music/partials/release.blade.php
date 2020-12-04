<li class="list-none bg-gray-100 border-grey-200">
    <div class="flex space-x-4 space-x-0 items-center">
        <img class="h-28 w-28" src="https://freek.dev/uploads/media/music/{{ $release['artwork'] }}" alt="Artwork">
        <div>
           <div class="font-bold">{{ $release['title'] }}</div>

            <div class="text-sm">
                @foreach($release['links'] as $label => $url)
                 <a href="{{ $url }}">{{ $label }}</a>

                    @if (! $loop->last)
                        |
                    @endif
                    @endforeach
            </div>


        </div>
    </div>

</li>
