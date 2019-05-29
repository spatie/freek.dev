@include('front.layouts.partials.head')

<div class="font-sans text-black">
    @include('front.layouts.partials.analytics')
    @include('front.layouts.partials.flash')

    <div class="max-w-xl lg:max-w-4xl mx-auto">
        <header class="mt-12 mb-16 px-8 leading-tight flex">
            <div class="flex items-end">
                <figure class="w-12 inline-block mr-3">
                    <a href="/"><img src="/images/murzicoon.svg" class="w-full"></a>
                </figure>
                <div>
                    <h1 class="text-lg uppercase tracking-wider font-extrabold">
                        <a href="/">Freek.dev</a>
                    </h1>
                    <p class="text-sm font-bold text-gray-500">
                        <a href="/">
                            Laravel
                            <span class="text-gray-300">/</span>
                            PHP
                            <span class="text-gray-300">/</span>
                            JavaScript
                        </a>
                    </p>
                </div>
            </div>
        </header>
        <div class="flex items-start pb-12">
            <nav class="hidden lg:block w-1/5 text-right leading-loose">
                <div class="border-r border-gray-200 px-8 mb-24">
                    {{ Menu::primary()
                        ->addClass('text-gray-700 mb-6')
                        ->setActiveClass('font-bold text-black') }}
                    {{ Menu::secondary()
                        ->addClass('text-xs text-gray-600') }}
                </div>
                <div class="pl-8">
                    @include('front.layouts.partials.carbonDummy')
                </div>
            </nav>
            <main class="w-4/5 px-8 lg:pl-24">
                @yield('content')
            </main>
        </div>
    </div>
</div>
