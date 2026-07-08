<header class="main-header">
    <div class="header-sticky bg-section">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ landing_route('landing') }}">
                    <img src="{{ landing_brand_logo_url($club ?? null) }}" alt="{{ landing_brand_name($club ?? null) }}">
                </a>

                <div class="collapse navbar-collapse main-menu">
                    <div class="nav-menu-wrapper">
                        <ul class="navbar-nav mr-auto" id="menu">
                            @foreach (config('landing.menu', []) as $item)
                                @if (Route::has($item['route']))
                                    <li class="nav-item">
                                        <a class="nav-link {{ ($currentRoute ?? '') === $item['route'] ? 'active' : '' }}"
                                           href="{{ route($item['route']) }}">
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="header-btn">
                        @if (Route::has(config('landing.cta.header_route', 'login')))
                            <a href="{{ route(config('landing.cta.header_route', 'login')) }}" class="btn-default">
                                {{ config('landing.cta.header_label', 'Entrar') }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="navbar-toggle"></div>
            </div>
        </nav>
        <div class="responsive-menu"></div>
    </div>
</header>