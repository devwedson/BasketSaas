<header class="app-header flex items-center px-4 gap-3.5">
    <a href="{{ route('dashboard') }}" class="logo-box">
        <div class="logo-light">
            <img src="{{ attex_asset(config('attex.brand.logo_light')) }}" class="logo-lg h-[22px]" alt="{{ config('app.name') }}">
            <img src="{{ attex_asset(config('attex.brand.logo_sm')) }}" class="logo-sm h-[22px]" alt="{{ config('app.name') }}">
        </div>
        <div class="logo-dark">
            <img src="{{ attex_asset(config('attex.brand.logo_dark')) }}" class="logo-lg h-[22px]" alt="{{ config('app.name') }}">
            <img src="{{ attex_asset(config('attex.brand.logo_sm')) }}" class="logo-sm h-[22px]" alt="{{ config('app.name') }}">
        </div>
    </a>

    <button id="button-toggle-menu" class="nav-link p-2">
        <span class="sr-only">Menu Toggle Button</span>
        <span class="flex items-center justify-center">
            <i class="ri-menu-2-fill text-2xl"></i>
        </span>
    </button>

    <div class="ms-auto flex items-center">
        <a href="{{ route('landing') }}" target="_blank" class="nav-link p-2 hidden md:flex" title="Ver site">
            <span class="flex items-center justify-center">
                <i class="ri-global-line text-2xl"></i>
            </span>
        </a>

        <div class="flex">
            <button id="light-dark-mode" type="button" class="nav-link p-2">
                <span class="sr-only">Alternar tema</span>
                <span class="flex items-center justify-center">
                    <i class="ri-moon-line text-2xl block dark:hidden"></i>
                    <i class="ri-sun-line text-2xl hidden dark:block"></i>
                </span>
            </button>
        </div>

        <div class="relative">
            <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link flex items-center gap-2.5 px-3 bg-black/5 border-x border-black/10 dark:bg-white/5 dark:border-white/10">
                <span class="flex items-center justify-center h-8 w-8 rounded-full bg-primary/10 text-primary shrink-0">
                    <span class="text-sm font-semibold leading-none">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </span>
                <span class="md:flex flex-col gap-0.5 text-start hidden">
                    <h5 class="text-sm text-gray-800 dark:text-gray-200 leading-none font-medium">{{ auth()->user()->name }}</h5>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role->label() }}</span>
                </span>
            </button>

            <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-44 z-50 transition-all duration-300 bg-white shadow-lg border rounded-lg py-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                <h6 class="flex items-center py-2 px-3 text-xs text-gray-800 dark:text-gray-400">Bem-vindo!</h6>

                <a href="{{ route('landing') }}" class="flex items-center gap-2 py-1.5 px-4 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                    <i class="ri-home-4-line text-lg align-middle"></i>
                    <span>Site</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 py-1.5 px-4 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                        <i class="ri-logout-box-line text-lg align-middle"></i>
                        <span>Sair</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>