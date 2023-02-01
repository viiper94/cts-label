<!doctype html>
<html lang="{{ str_replace('ua', 'uk', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('description')">
{{--    <meta name="keywords" content="@yield('keywords')">--}}
    @yield('meta')
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>@yield('title', "CTS Records")</title>
    <link type="text/css" rel="stylesheet" href="{{  mix('css/app.css') }}" media="screen,projection"/>
    @yield('assets')
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-79851603-1', 'auto');
        ga('send', 'pageview');
    </script>
    @include('layout.scripts')
    @yield('json-ld')
</head>
<body>
    <div id="fb-root"></div>
    @include('layout.header')
    <main class="pb-4">
        @include('admin.layout.alert')
        @yield('content')
    </main>
    @include('layout.footer')
</body>
</html>
