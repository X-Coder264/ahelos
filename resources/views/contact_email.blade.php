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
    <link href="/assets/css/app.css" rel="stylesheet">
    @yield('styles')
    <link href="/assets/css/custom.min.css" rel="stylesheet">
    <script src="/assets/js/app.js"></script>
</head>
<body>

Imate novu poruku na koju možete odgovoriti u Admin Panelu. <br>

Poslao: {{$contact_message->sender_name}} <br>
Email: {{$contact_message->sender_email}} <br>
Naslov: {{$contact_message->subject}} <br>
Poruka: {{$contact_message->message}} <br>

</body>
</html>
