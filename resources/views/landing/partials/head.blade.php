<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta name="description" content="{{ config('landing.brand.tagline') }}">
<meta name="author" content="{{ config('landing.brand.name') }}">
<title>{{ page_title($pageTitle ?? null) }}</title>
<link rel="shortcut icon" type="image/x-icon" href="{{ landing_favicon_url($club ?? null) }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="{{ neodunk_asset('css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
<link href="{{ neodunk_asset('css/slicknav.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ neodunk_asset('css/swiper-bundle.min.css') }}">
<link href="{{ neodunk_asset('css/all.min.css') }}" rel="stylesheet" media="screen">
<link href="{{ neodunk_asset('css/animate.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ neodunk_asset('css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ neodunk_asset('css/mousecursor.css') }}">
<link href="{{ neodunk_asset('css/custom.css') }}" rel="stylesheet" media="screen">
<style>
    /* Menu hover/active — Neodunk (sobrescreve Bootstrap .nav-link.active) */
    .main-menu ul li a.nav-link:hover,
    .main-menu ul li a.nav-link:focus,
    .main-menu ul li a.nav-link.active {
        color: var(--accent-secondary-color);
    }

    .main-menu ul li a.nav-link.active {
        font-weight: 600;
    }

    .navbar-nav .nav-link.active,
    .navbar-nav .nav-link.show {
        color: var(--accent-secondary-color);
    }

    header.main-header .header-sticky.active .main-menu ul li a.nav-link:hover,
    header.main-header .header-sticky.active .main-menu ul li a.nav-link:focus,
    header.main-header .header-sticky.active .main-menu ul li a.nav-link.active {
        color: var(--accent-secondary-color);
    }

    .slicknav_nav li a.active,
    .slicknav_nav li a.active:hover,
    .slicknav_nav li a.active:focus {
        color: var(--primary-color);
        background-color: transparent;
    }
</style>
@stack('styles')