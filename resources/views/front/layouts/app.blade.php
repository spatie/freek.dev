@props(['wide' => false, 'title' => null, 'canonical' => null, 'hideBio' => false])

@include('front.layouts.partials.head')

<body>

<div class="font-sans text-black">
    @include('front.layouts.partials.analytics')
    @include('front.layouts.partials.flash')

    <div class="max-w-xl md:max-w-6xl mx-auto overflow-x-clip">
        <header class="mt-8 md:mt-12 mb-8 sm:mb-12 md:mb-16 px-4 md:px-8 leading-tight">
            <div class="md:flex items-end">
                <figure class="w-12 inline-block mb-1 md:mb-0 md:mr-3">
                    <a href="/" title="Freek.dev">
                        <svg class="w-full" viewBox="0 0 285 300" xmlns="http://www.w3.org/2000/svg" aria-label="Freek.dev logotype">
                            <g fill="none" fill-rule="evenodd">
                                <path fill="#FFF" d="M15 15h240v255H15z"/>
                                <path d="M270 15h15v285H15v-15H0V0h270v15zM15 15v255h240V15H15z" fill="#000"/>
                                <path class="gameboy-screen" fill="#D8D8D8" d="M60 60h150v90H60z"/>
                                <defs>
                                    <clipPath id="screen-clip"><rect x="60" y="60" width="150" height="90"/></clipPath>
                                </defs>
                                <rect clip-path="url(#screen-clip)" x="60" width="150" height="20" fill="rgba(255,255,255,0.3)">
                                    <animate attributeName="y" values="40;150;40" dur="3s" repeatCount="indefinite"/>
                                </rect>
                                <path fill="#000" d="M45 45h183v120H45V45zm15 15v90h150V60H60z"/>
                                <path class="gameboy-dpad" fill="#000" d="M57.5 207v-17.5h20V207H95v20H77.5v17.5h-20V227H40v-20z"/>
                                <rect class="gameboy-btn-b" fill="#000" x="145" y="205" width="25" height="25"/>
                                <rect class="gameboy-btn-a" fill="#000" x="190" y="205" width="25" height="25"/>
                            </g>
                        </svg>
                    </a>
                </figure>
                <div>
                    <h1 class="text-lg uppercase tracking-wider font-extrabold">
                        <a href="/">Freek.dev</a>
                    </h1>
                    <p class="text-sm font-bold text-gray-600">
                        <a href="/">
                            Laravel
                            <span class="text-gray-300">/</span>
                            PHP
                            <span class="text-gray-300">/</span>
                            AI
                        </a>
                    </p>
                </div>
            </div>
            <nav class="md:hidden relative">
                <input class="hidden" type="checkbox" id="mobile-menu-toggle" />
                <label
                    for="mobile-menu-toggle"
                    class="absolute bg-gray-700 border-b-3 border-gray-900 text-white uppercase tracking-wider font-semibold p-2 pb-1"
                    style="top: -6rem; right: 0"
                >
                    Menu
                </label>
                <div class="mobile-menu | pt-4 text-right leading-loose">
                    {{ Menu::primary()
                        ->addClass('text-gray-700 mb-2 md:mb-6')
                        ->setActiveClass('font-bold text-black') }}
                    {{ Menu::secondary()
                        ->addClass('text-xs text-gray-700')
                        ->setActiveClass('font-semibold text-black') }}
                </div>
            </nav>
        </header>
        <div class="md:flex pb-12">
            <nav class="hidden md:block w-1/4 lg:w-1/5 text-right leading-loose">
                <div class="border-r border-gray-200 px-8 mb-16">
                    {{ Menu::primary()
                        ->addClass('text-gray-700 mb-6')
                        ->setActiveClass('font-bold text-black') }}
                    {{ Menu::secondary()
                        ->addClass('text-xs text-gray-700')
                        ->setActiveClass('font-semibold text-black') }}
                    <div class="mt-4">
                        <a href="https://x.com/freekmurze" target="_blank" rel="noopener noreferrer" class="text-xs text-gray-700 hover:text-black transition-colors" title="Follow on X">
                            <svg class="w-3.5 h-3.5 inline" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    </div>
                </div>
                <div class="pl-8">
                    @include('front.layouts.partials.carbon')
                </div>
            </nav>
            <main class="flex-1 min-w-0 px-4 md:px-12 lg:pl-12 lg:pr-8">
                @if($wide)
                    {{ $slot }}
                @else
                    <div class="min-[1140px]:grid min-[1140px]:grid-cols-[minmax(0,560px)_220px] min-[1140px]:gap-12">
                        <div class="min-w-0 max-w-[560px]">
                            {{ $slot }}
                        </div>
                        <aside class="hidden min-[1140px]:block">
                            <div class="sticky top-8 space-y-8">
                                @unless($hideBio)
                                    @include('front.layouts.partials.bio')
                                @endunless
                                @if(isset($sidebarTop))
                                    {{ $sidebarTop }}
                                @endif
                                <x-ad/>
                            </div>
                        </aside>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>

@livewireScriptConfig

</body>

