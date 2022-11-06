<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ ucfirst(Route::currentRouteName())}}</title>
        <link rel="stylesheet" href="{{ url('assets/css/reset.css') }}">
        <link rel="stylesheet" href="{{ url('assets/css/app.css') }}">
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-R0GX9KF0TH"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-R0GX9KF0TH');
        </script>
    </head>
    <body>
        <div id="app">
            @yield('content')
        </div>
    </body>
</html>
