<x-app-layout title="Music">
    <div class="markup mb-8">
        <h1>Music</h1>
        <p>
            I love both listening to and creating music. On this page you'll find some music that I made.
        </p>

        <h2 id="tax-shelter">
            Tax Shelter
            <a href="#tax-shelter" class="permalink">#</a>
        </h2>

        <p>
            Together with my buddy Thomas, I create music using mainly analogue synths. We've already made a lot of tracks, which we're slowly releasing. These songs are for the most instrumental and are for adventurous listeners.
        </p>

        <ul class="list-none text-gray-700 space-y-4">
            @foreach($releases['taxShelter'] as $release)
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

        <h2 id="topologies">
            Topologies
            <a href="#topologies" class="permalink">#</a>
        </h2>

        <p>
            Topologies is my currently active band. We converted our rehearsal room to a recording space, and are usually crafting songs without the aim of ever performing them live. Expect songs with wild structures, and a wide range of instruments and electronics.
        </p>

        <ul class="list-none text-gray-700 space-y-4">
            @foreach($releases['topologies'] as $release)
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
