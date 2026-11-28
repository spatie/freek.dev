<x-app-layout title="Music">
    <div class="mb-8">
        <div class="markup">
            <h1>Music</h1>
        </div>
        <p class="mt-3 mb-8 leading-relaxed text-gray-700">
            I love both listening to and creating music. Here's everything I've released, across four projects:
            from my current band to the krautrock I played in Antwerp.
        </p>

        <section aria-labelledby="kobus">
            <div class="markup mb-2">
                <h2 id="kobus" class="!mt-0">Kobus</h2>
            </div>
            <p class="mb-5 max-w-[520px] leading-relaxed text-gray-600">
                Every now and then I take some time to record music of my own under the name Kobus.
                If you like indietronica, you'll probably like this.
            </p>
            <ul class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-6">
                @foreach($releases['kobus'] as $release)
                    @include('front.music.partials.release')
                @endforeach
            </ul>
        </section>

        <section class="mt-12" aria-labelledby="topologies">
            <div class="markup mb-2">
                <h2 id="topologies" class="!mt-0">Topologies</h2>
            </div>
            <p class="mb-5 max-w-[520px] leading-relaxed text-gray-600">
                We converted our rehearsal room to a recording space, crafting songs without the aim of ever
                performing them live. Expect wild structures and a wide range of instruments and electronics.
            </p>
            <ul class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-6">
                @foreach($releases['topologies'] as $release)
                    @include('front.music.partials.release')
                @endforeach
            </ul>
        </section>

        <section class="mt-12" aria-labelledby="tax-shelter">
            <div class="markup mb-2">
                <h2 id="tax-shelter" class="!mt-0">Tax Shelter</h2>
            </div>
            <p class="mb-5 max-w-[520px] leading-relaxed text-gray-600">
                With my buddy Thomas, I make mostly instrumental music on analog synths, for adventurous
                listeners who love exploring new sounds. Lots more is finished and slowly coming out.
            </p>
            <ul class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-6">
                @foreach($releases['taxShelter'] as $release)
                    @include('front.music.partials.release')
                @endforeach
            </ul>
        </section>

        <section class="mt-12" aria-labelledby="jarenduren">
            <div class="markup mb-2">
                <h2 id="jarenduren" class="!mt-0">jarenduren</h2>
            </div>
            <p class="mb-5 max-w-[520px] leading-relaxed text-gray-600">
                An Antwerp band in which I mainly played guitars, heavily influenced by krautrock bands
                like Neu, Can, My Disco and Harmonia.
            </p>
            <ul class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-6">
                @foreach($releases['jarenduren'] as $release)
                    @include('front.music.partials.release')
                @endforeach
            </ul>
        </section>
    </div>
</x-app-layout>
