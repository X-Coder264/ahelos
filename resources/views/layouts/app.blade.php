<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ahelos</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ahelos">
    <meta name="keywords" content="Ahelos, IT">
    <meta name="author" content="Antonio Pauletich">
    <meta name="application-name" content="Ahelos">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=m2drEWAMa3">
    <link rel="icon" type="image/png" href="/favicon-32x32.png?v=m2drEWAMa3" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png?v=m2drEWAMa3" sizes="16x16">
    <link rel="manifest" href="/manifest.json?v=m2drEWAMa3">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=m2drEWAMa3">
    <link rel="shortcut icon" href="/favicon.ico?v=m2drEWAMa3">
    <meta name="apple-mobile-web-app-title" content="Ahelos">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png?v=m2drEWAMa3">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/assets/css/app.css" rel="stylesheet">
    @yield('styles')
    <link href="/assets/css/custom.min.css" rel="stylesheet">
    <script>window.Laravel=<?php echo json_encode(['csrfToken' => csrf_token(),]); ?></script>
    <script src="/assets/js/app.js"></script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Glavni izbornik</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            @yield('navigation')
        </div>
    </nav>
    @yield('content')
    @yield('scripts')
</body>
</html>
