<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>CTS Records Admin Panel</title>
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.floatingscroll.css">
    <link href="/assets/css/cts-admin.css?0910" rel="stylesheet">
    @yield('assets')
    @include('admin.layout.scripts')
</head>
<body>
    @include('admin.layout.header')
    <section class="main-content">
        @yield('admin-content')
    </section>
</body>
</html>
