<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>@yield('title', "CTS Records")</title>
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/cts1.css" rel="stylesheet">
    @yield('assets')
</head>
<body>
    <div id="fb-root"></div>
    @include('layout.header')
    <section class = "main-content">
        @yield('content')
    </section>
    @include('layout.footer')
    @include('layout.scripts')
</body>
</html>
