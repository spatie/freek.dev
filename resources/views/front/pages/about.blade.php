<x-app-layout title="About" :hide-bio="true">
    <div class="markup mb-6">
        <h1>About</h1>
    </div>
    <img
        src="{{ url('images/avatar-boxed.jpg') }}"
        alt="Freek Van der Herten speaking at Laracon EU 2018"
        class="sm:w-48 sm:ml-3 mb-6 sm:mb-0 sm:rounded-full sm:float-right"
    >
    <div class="markup">
        <p>
            I'm the co-owner of <a href="https://spatie.be">Spatie</a>, where my colleagues and I maintain <a href="https://spatie.be/open-source">over 300 open source packages</a> for PHP and Laravel. Those packages have been downloaded more than 2 billion times.
        </p>
        <p>
            Whenever we stumble upon a problem that we can solve in a clean way, we extract our solution so other developers can use it. On this blog, I write about what I learn along the way.
        </p>
        <h2 id="side-projects">
            Side projects
        </h2>
        <p>
            Together with my friend <a href="https://x.com/mattiasgeniar">Mattias</a>, I run <a href="https://ohdear.app">Oh Dear</a>, a website monitoring service. It can notify you when your site is down, when it contains broken links, when it finds mixed content, and much more. <a href="https://ohdear.app/register">Try it out!</a>
        </p>
        <p>
            Outside of programming, I'm passionate about music. I record music in <a href="https://www.ableton.com">Ableton</a> and have released a couple of EPs. You can listen to them on <a href="https://open.spotify.com/artist/6m5chdjU0M8j8bMmckXRkc">Spotify</a> or <a href="https://music.apple.com/be/artist/kobus/1529028832">Apple Music</a>.
        </p>
    </div>

    <div class="mt-8 mb-8">
        @include('front.posts.partials.popular')
    </div>

    @include('front.newsletter.partials.block')
</x-app-layout>
