<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>@yield('title', "CTS Records Admin Panel")</title>
    <link type="text/css" rel="stylesheet" href="{{  mix('css/admin.css') }}" media="screen,projection"/>
    @yield('assets')
    @include('admin.layout.scripts')
</head>
<body class="d-flex-md">
    @include('admin.layout.sidebar')
    <main class="main-content flex-grow-1 position-relative">
        @yield('admin-content')
    </main>
</body>
</html>
