<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-mode="light" data-menu-color="dark" data-topbar-color="light" data-layout-width="default" data-layout-position="fixed">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ attex_asset(config('attex.brand.favicon')) }}">
    <link href="{{ attex_asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ attex_asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ attex_asset('assets/js/config.js') }}"></script>
    @stack('styles')
</head>
<body>
    <div class="flex wrapper">
        @include('layouts.attex.sidebar')

        <div class="page-content">
            @include('layouts.attex.topbar')

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ attex_asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ attex_asset('assets/libs/lucide/umd/lucide.min.js') }}"></script>
    <script src="{{ attex_asset('assets/libs/@frostui/tailwindcss/frostui.js') }}"></script>
    <script src="{{ attex_asset('assets/js/app.js') }}"></script>
    @include('partials.attex.sweetalert')
    @stack('scripts')
</body>
</html>