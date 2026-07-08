<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('landing.partials.head')
</head>
<body>
    @include('landing.partials.preloader')
    @include('landing.partials.header')

    @yield('content')

    @include('landing.partials.footer')
    @include('landing.partials.scripts')
</body>
</html>