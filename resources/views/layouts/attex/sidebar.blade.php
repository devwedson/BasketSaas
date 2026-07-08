<div class="app-menu">
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

    <button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5 z-50">
        <span class="sr-only">Menu Toggle Button</span>
        <i class="ri-checkbox-blank-circle-line text-xl"></i>
    </button>

    <div class="scrollbar" data-simplebar>
        <ul class="menu" data-fc-type="accordion">
            <li class="menu-title">Navegação</li>

            <li class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ri-dashboard-line"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->isSuperAdmin())
                <li class="menu-title">Administração</li>
                <li class="menu-item">
                    <a href="{{ route('clubs.index') }}" class="menu-link {{ request()->routeIs('clubs.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-building-2-line"></i></span>
                        <span class="menu-text">Clubes</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('landing.settings.edit') }}" class="menu-link {{ request()->routeIs('landing.settings.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-global-line"></i></span>
                        <span class="menu-text">Landing / Site</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('smtp.settings.edit') }}" class="menu-link {{ request()->routeIs('smtp.settings.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-mail-settings-line"></i></span>
                        <span class="menu-text">SMTP / E-mail</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole(\App\Enums\UserRole::SuperAdmin, \App\Enums\UserRole::Club))
                <li class="menu-title">Site Público</li>
                @if (auth()->user()->hasRole(\App\Enums\UserRole::Club))
                    <li class="menu-item">
                        <a href="{{ route('club.settings.edit') }}" class="menu-link {{ request()->routeIs('club.settings.*') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ri-global-line"></i></span>
                            <span class="menu-text">Landing do Clube</span>
                        </a>
                    </li>
                @endif
                <li class="menu-item">
                    <a href="{{ route('sponsors.index') }}" class="menu-link {{ request()->routeIs('sponsors.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-hand-heart-line"></i></span>
                        <span class="menu-text">Patrocinadores</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole(\App\Enums\UserRole::SuperAdmin, \App\Enums\UserRole::Club, \App\Enums\UserRole::Coach, \App\Enums\UserRole::Assistant))
                <li class="menu-title">Gestão</li>

                <li class="menu-item">
                    <a href="{{ route('teams.index') }}" class="menu-link {{ request()->routeIs('teams.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-team-line"></i></span>
                        <span class="menu-text">Times</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('players.index') }}" class="menu-link {{ request()->routeIs('players.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-user-star-line"></i></span>
                        <span class="menu-text">Jogadores</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('staff.index') }}" class="menu-link {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-user-settings-line"></i></span>
                        <span class="menu-text">Comissão Técnica</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('trainings.index') }}" class="menu-link {{ request()->routeIs('trainings.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-basketball-line"></i></span>
                        <span class="menu-text">Treinos</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('games.index') }}" class="menu-link {{ request()->routeIs('games.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-trophy-line"></i></span>
                        <span class="menu-text">Jogos</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('calendar.index') }}" class="menu-link {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-calendar-event-line"></i></span>
                        <span class="menu-text">Calendário</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('reports.index') }}" class="menu-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ri-file-chart-line"></i></span>
                        <span class="menu-text">Relatórios</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>