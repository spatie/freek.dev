@if($highlightFirstPost ?? false)
    @include('front.posts.partials.listItems.highlighted', [
        'post' => $posts->shift(),
    ])
@endif

@foreach($posts as $post)
    @if($loop->index === 2)
        <div class="mb-24">
            @include('front.newsletter.partials.form')
        </div>
    @endif
    <div class="flex">
        <div class="w-2/3 pr-8">
            @include("front.posts.partials.listItems.{$post->type}")
        </div>
        @if($loop->first)
            <div class="flex-1 pl-8 flex flex-col items-end justify-between">
                <div class="text-xs mb-4 mt-32" style="max-width: 11rem">
                    <div id="carbonads">
                        <span>
                            <span class="block bg-paper-dark leading-tight border border-paper-darker" style="box-shadow: 4px 4px 0 0 var(--paper-darker)">
                                <a href="https://srv.carbonads.net/ads/click/x/GTND42QMC6AI427YCKSLYKQMCWYIL27NCWAI5Z3JCWBI6K3UCABIT2JKC6BIPKQYF6ADEK3EHJNCLSIZ?segment=placement:murzebe;" class="carbon-img block mx-3 mt-3 mb-2" target="_blank" rel="noopener">
                                    <img src="https://cdn4.buysellads.net/uu/1/41312/1547504724-bugsnaglogopattern260x200.png" alt="" border="0" height="100" width="130">
                                </a>
                                <a href="https://srv.carbonads.net/ads/click/x/GTND42QMC6AI427YCKSLYKQMCWYIL27NCWAI5Z3JCWBI6K3UCABIT2JKC6BIPKQYF6ADEK3EHJNCLSIZ?segment=placement:murzebe;" class="carbon-text block px-4 pb-3" target="_blank" rel="noopener">Swift &amp; straightforward bug fixes for your web &amp; mobile apps. Try Bugsnag free.</a>
                            </span>
                            <a href="http://carbonads.net/?utm_source=murzebe&amp;utm_medium=ad_via_link&amp;utm_campaign=in_unit&amp;utm_term=carbon" class="carbon-poweredby block mt-1 text-right text-gray bg-paper" target="_blank" rel="noopener">ads via Carbon</a><img src="https://www.bugsnag.com/by-role/software-engineer/?utm_source=carbon&amp;utm_medium=cpc&amp;utm_content=software-engineer&amp;utm_campaign=2019-q1&amp;utm_term=swift-bugs" border="0" height="1" width="1" style="display:none">
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endforeach
