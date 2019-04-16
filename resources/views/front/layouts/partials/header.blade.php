<header class="flex items-end justify-between px-12 pt-6 pb-8 leading-tight">
    <div class="flex items-end">
        <div class="w-12 mr-3">
            <img src="/images/murzicoon.svg" class="w-full">
        </div>
        <div class="font-title uppercase tracking-wider">
            <h1 class="mr-2">Murze.be</h1>
            <p class="text-blue text-sm">
                Laravel
                <span class="text-gray-light">/</span>
                PHP
                <span class="text-gray-light">/</span>
                JavaScript
            </p>
        </div>
    </div>
    <nav class="font-sans font-black tracking-wide">
        {{ Menu::main()
            ->addClass('flex')
            ->addItemParentClass('ml-6') }}
    </nav>
</header>
