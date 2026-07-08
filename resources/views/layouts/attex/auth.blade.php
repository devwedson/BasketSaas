<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-mode="light" data-menu-color="dark" data-topbar-color="light" data-layout-width="default" data-layout-position="fixed">
<head>
    <meta charset="utf-8">
    <title>{{ config('attex.auth.title') }} | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('attex.auth.subtitle') }}">
    <link rel="shortcut icon" href="{{ attex_asset(config('attex.brand.favicon')) }}">
    <link href="{{ attex_asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ attex_asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ attex_asset('assets/js/config.js') }}"></script>
</head>
<body class="relative flex flex-col">
    @inject('attexTemplate', 'App\Support\AttexTemplate')
    {!! $attexTemplate->authBackground() !!}

    <div class="relative flex flex-col items-center justify-center min-h-screen">
        <div class="flex justify-center w-full">
            <div class="max-w-md px-4 mx-auto w-full">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="absolute bottom-0 inset-x-0">
        <p class="font-medium text-center p-6 text-sm text-gray-500 dark:text-gray-400">
            {{ now()->year }} © {{ config('attex.auth.footer', config('app.name')) }}
        </p>
    </footer>

    <script src="{{ attex_asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ attex_asset('assets/libs/lucide/umd/lucide.min.js') }}"></script>
    <script src="{{ attex_asset('assets/libs/@frostui/tailwindcss/frostui.js') }}"></script>
    <script src="{{ attex_asset('assets/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>