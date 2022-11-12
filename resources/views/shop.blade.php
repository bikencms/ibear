<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home page</title>
    <link rel="stylesheet" href="{{ url('assets/css/reset.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/shop.css') }}">
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
@include('layouts.head')
<footer class="text-center">
    <p>© <?= date('Y') ?> - Toàn bộ bản quyền thuộc ibear.vn</p>
</footer>
</body>