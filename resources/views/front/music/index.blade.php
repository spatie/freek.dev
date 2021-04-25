<x-app-layout title="Music">
    <div class="markup mb-8">
        <h1>Music</h1>
        <p>
            I love both listening to and creating music. On this page you'll find playlists created by the team at <a href="https://spatie.be">Spatie</a>, and some music of my own.
        </p>

        <h2>Corporate Melodies</h2>
        <p>
            Every month, my colleagues and I created a playlist around a theme.

        </p>

        <ul class="list-none text-gray-700 space-y-4">
            @foreach($releases['corporateMelodies'] as $release)
                @include('front.music.partials.release')
            @endforeach
        </ul>

        <h2>Kobus</h2>

        <p>
            Every now and then I take some time to record some
            music of my own under my artist name Kobus. If you like indietronica, you'll probably like this.
        </p>

        <ul class="list-none text-gray-700 space-y-4">
            @foreach($releases['kobus'] as $release)
                @include('front.music.partials.release')
            @endforeach
        </ul>

        <h2>jarenduren</h2>
        <p>
            jarenduren was an Antwerp band, in which I mainly played guitars. Our music was heavily influenced by krautrock bands like Neu, Can, My Disco, Harmonia...
        </p>
        <ul class="list-none text-gray-700 space-y-4">
            @foreach($releases['jarenduren'] as $release)
                @include('front.music.partials.release')
            @endforeach
        </ul>
    </div>
</x-app-layout>
