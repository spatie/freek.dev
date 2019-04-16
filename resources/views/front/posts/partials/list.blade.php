<main class="posts px-12">
    @php($post = $posts->shift())

    <article class="post post--large pt-12 mb-16 relative">
        <div class="w-2/3">
            <header class="mb-8">
                <h2 class="font-title uppercase text-3xl w-3/4 mb-2 leading-tight">
                    {{ $post->title }}
                </h2>
                <div class="font-serif text-sm text-gray-darker">
                    <p>
                        {{ $post->publish_date->format('F d, Y') }}
                        by Freek Van der Herten
                    </p>
                </div>
            </header>
            <div class="font-serif markup relative text-lg">
                {!! $post->excerpt !!}
            </div>
        </div>
        <div class="absolute right-0 bottom-0" style="max-width: 14rem">
            <div class="text-xs"><div id="carbonads" class="bg-paper-dark leading-tight"><span><span class="carbon-wrap"><a href="https://srv.carbonads.net/ads/click/x/GTND42QMC6AI427YCKSLYKQMCWYIL27NCWAI5Z3JCWBI6K3UCABIT2JKC6BIPKQYF6ADEK3EHJNCLSIZ?segment=placement:murzebe;" class="carbon-img block mb-3" target="_blank" rel="noopener"><img src="https://cdn4.buysellads.net/uu/1/41312/1547504724-bugsnaglogopattern260x200.png" alt="" border="0" height="100" width="130" style="max-width:130px"></a><a href="https://srv.carbonads.net/ads/click/x/GTND42QMC6AI427YCKSLYKQMCWYIL27NCWAI5Z3JCWBI6K3UCABIT2JKC6BIPKQYF6ADEK3EHJNCLSIZ?segment=placement:murzebe;" class="carbon-text block px-4 pb-4" target="_blank" rel="noopener">Swift &amp; straightforward bug fixes for your web &amp; mobile apps. Try Bugsnag free.</a></span><a href="http://carbonads.net/?utm_source=murzebe&amp;utm_medium=ad_via_link&amp;utm_campaign=in_unit&amp;utm_term=carbon" class="carbon-poweredby block pt-1 text-right text-gray bg-paper" target="_blank" rel="noopener">ads via Carbon</a><img src="https://www.bugsnag.com/by-role/software-engineer/?utm_source=carbon&amp;utm_medium=cpc&amp;utm_content=software-engineer&amp;utm_campaign=2019-q1&amp;utm_term=swift-bugs" border="0" height="1" width="1" style="display:none"></span></div></div>
        </div>
    </article>

    @foreach($posts as $post)
        <article class="post border p-8">
            <header class="mb-4">
                <h2 class="font-title uppercase text-lg mb-2 leading-tight">
                    {{ $post->title }}
                </h2>
                <div class="font-sans text-gray-darker text-sm">
                    <p class="">
                        {{ $post->publish_date->format('F d, Y') }}
                    </p>
                    <ul class="inline-flex text-blue">
                        @foreach($post->tags as $tag)
                            <li class="mr-2">#{{ $tag->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </header>
            <div class="font-serif markup">
                {{ \Faker\Factory::create()->text }}
                <p class="mt-6">
                    <a href="#" class="text-sm inline-block bg-blue text-paper px-4 py-2 text-xl font-sans font-bold">
                        →
                    </a>
                </p>
            </div>
        </article>
    @endforeach
</main>
