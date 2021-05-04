<x-app-layout title="Music">
    <div class="markup mb-8">
        <h1>Music</h1>
        <p>
            I love both listening to and creating music. On this page you'll find playlists created by the team at <a href="https://spatie.be">Spatie</a>, and <a href="#kobus">some music of my own</a>.
        </p>

        <h2 id="corporate-melodies">
            Corporate Melodies
            <a href="#corporate-melodies" class="permalink">#</a>
        </h2>
        <p>
            Every month, our team at Spatie creates a playlist around a theme.

        </p>

        <ul class="list-none text-gray-700 space-y-4">
            @foreach($releases['corporateMelodies'] as $release)
                @include('front.music.partials.release')
            @endforeach
        </ul>

        <h2 id="kobus">
            Kobus
            <a href="#kobus" class="permalink">#</a>
        </h2>

        <p>
            Every now and then I take some time to record some
            music of my own under my artist name Kobus. If you like indietronica, you'll probably like this.
        </p>

        <ul class="list-none text-gray-700 space-y-4">
            @foreach($releases['kobus'] as $release)
                @include('front.music.partials.release')
            @endforeach
        </ul>

        <h2 id="jarenduren">
            jarenduren
            <a href="#jarenduren" class="permalink">#</a>
        </h2>

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
