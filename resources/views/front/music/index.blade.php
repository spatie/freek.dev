<x-app-layout title="Music">
    <div class="markup mb-8">
        <h1>Music</h1>
        <p>
            Every now and then I take some time to record some
            music of my own under my artist name Kobus.

        </p>

        <p>
            Here are some of my releases:
        </p>

        <ul class="list-none text-gray-700 space-y-4">
            @foreach($releases as $release)
                @include('front.music.partials.release')
            @endforeach
        </ul>
    </div>
</x-app-layout>
