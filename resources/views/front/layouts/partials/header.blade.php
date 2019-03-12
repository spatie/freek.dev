<header class="flex items-end justify-between px-24 py-12">
    <div class="font-bold uppercase tracking-wider leading-tight">
        <h1 class="mr-2">Murze.be</h1>
        <p class="text-blue text-sm">
            Laravel
            <span class="text-grey-light">/</span>
            PHP
            <span class="text-grey-light">/</span>
            JavaScript
        </p>
        </div>
        <nav class="text-sm font-bold tracking-wide">
            {{ Menu::main()
                ->addClass('flex')
                ->addItemParentClass('mr-8') }}
        </nav>
    </div>
</header>
