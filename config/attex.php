<?php

return [

    'assets' => [
        'prefix' => env('ATTEX_ASSETS_PATH', 'attex'),
    ],

    'brand' => [
        'logo_light' => env('ATTEX_LOGO_LIGHT', 'assets/images/logo.png'),
        'logo_dark' => env('ATTEX_LOGO_DARK', 'assets/images/logo-dark.png'),
        'logo_sm' => env('ATTEX_LOGO_SM', 'assets/images/logo-sm.png'),
        'favicon' => env('ATTEX_FAVICON', 'assets/images/favicon.ico'),
    ],

    'auth' => [
        'title' => env('AUTH_PAGE_TITLE', 'Entrar'),
        'subtitle' => env('AUTH_PAGE_SUBTITLE', 'Acesse o painel de gestão do seu clube.'),
        'footer' => env('AUTH_PAGE_FOOTER'),
    ],

];