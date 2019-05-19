<header class="flex items-end justify-start mt-6 mb-20 h-16 leading-tight">
    <figure class="w-12 mr-3">
        <a href="/"><img src="/images/murzicoon.svg" class="w-full"></a>
    </figure>
    <div class="font-title uppercase tracking-wider">
        <h1><a href="/">Freek.dev</a></h1>
        <p class="text-blue text-sm">
            <a href="/">
                Laravel
                <span class="text-gray-light">/</span>
                PHP
                <span class="text-gray-light">/</span>
                JavaScript
            </a>
        </p>
    </div>
    <nav class="flex-1 flex justify-end text-gray-darker">
        {{ Menu::main()
            ->addClass('flex -mr-4 -mb-1')
            ->addItemClass('inline-block px-4 pt-2 pb-2')
            ->addItemParentClass('ml-2')
            ->setActiveClass('font-bold text-paper-darkest') }}
    </nav>
</header>
