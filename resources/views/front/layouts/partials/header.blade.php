<header class="flex items-end justify-start mt-6 mb-20 h-16 leading-tight">
    <figure class="w-12 mr-3">
        <img src="/images/murzicoon.svg" class="w-full">
    </figure>
    <div class="font-title uppercase tracking-wider">
        <h1>Murze.be</h1>
        <p class="text-blue text-sm">
            Laravel
            <span class="text-gray-light">/</span>
            PHP
            <span class="text-gray-light">/</span>
            JavaScript
        </p>
    </div>
    <nav class="flex-1 flex justify-end font-medium text-gray-darker">
        {{ Menu::main()
            ->addClass('flex -mr-4 -mb-1')
            ->addItemClass('inline-block px-4 pt-10 pb-2')
            ->addItemParentClass('ml-2')
            ->setActiveClass('bg-paper-dark') }}
    </nav>
</header>
