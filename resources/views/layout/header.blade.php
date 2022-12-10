<header class="pt-2">
    <div class="container">
        <a href="{{ route('home') }}"><img src="/assets/img/logo.png" class="logo" alt="Creative Technology Studio"/></a>
{{--                    @guest--}}
{{--                        <a href="{{ route('register') }}" class="pull-right">@lang('user.register')&nbsp;</a>--}}
{{--                        <a href="{{ route('login') }}" class="pull-right">@lang('user.login')&nbsp;</a>--}}
{{--                    @else--}}
{{--                        <a href="{{ route('logout') }}" class="pull-right"--}}
{{--                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('user.logout')</a>--}}
{{--                        <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">--}}
{{--                            @csrf--}}
{{--                        </form>--}}
{{--                        <a href="{{ route('profile') }}" class="pull-right">{{ Auth::user()->name }}&nbsp;</a>--}}
{{--                        @can('admin') <a href="{{ route('releases_admin') }}" class="pull-right">@lang('navbar.admin')&nbsp;</a> @endcan--}}
{{--                    @endguest--}}
    </div>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <a class="navbar-brand" href="#">Hidden brand</a>
                <ul class="navbar-nav me-auto text-light">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                </form>
            </div>
        </div>
    </nav>



{{--    <div class="black" id="main_nav">--}}
{{--        <div class="container">--}}
{{--            <div class="col-xs-12">--}}
{{--                <div class="row">--}}
{{--                    <nav class="navbar navbar-default" id="nav">--}}
{{--                        <div class="container-fluid">--}}
{{--                            <div class="navbar-brand">--}}
{{--                                <a href="/"><img src="/assets/img/logo-small.png" alt="Creative technology Studio" class="sticky-logo"/></a>--}}
{{--                            </div>--}}
{{--                            <div class="navbar-header navbar-left">--}}
{{--                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu-collapse" aria-expanded="false">--}}
{{--                                    <span class="sr-only">Toggle navigation</span>--}}
{{--                                    <span class="icon-bar"></span>--}}
{{--                                    <span class="icon-bar"></span>--}}
{{--                                    <span class="icon-bar"></span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div class="collapse navbar-collapse navbar-left" id="main-menu-collapse">--}}
{{--                                <ul class="nav navbar-nav">--}}
{{--                                    <li @if(\Route::is('home'))class="active" @endif><a href="{{ route('home') }}">@lang('navbar.home')</a></li>--}}
{{--                                    <li @if(\Route::is('about'))class="active" @endif id="about-menu"><a href="{{ route('about') }}">@lang('navbar.about')</a></li>--}}
{{--                                    <li @if(\Route::is('artists'))class="active" @endif><a href="{{ route('artists') }}">@lang('navbar.artists')</a></li>--}}
{{--                                    <li @if(\Route::is('studio'))class="active" @endif><a href="{{ route('studio') }}">@lang('navbar.studio')</a></li>--}}
{{--                                    <li @if(\Route::is('school'))class="active" @endif><a href="{{ route('school') }}">@lang('navbar.school')</a></li>--}}
{{--                                    <li @if(\Route::is('reviews'))class="active" @endif><a href="{{ route('reviews') }}">@lang('navbar.reviews')</a></li>--}}
{{--                                    <li id="demo-menu"><a href="{{ route('about') }}#demo">@lang('navbar.demo')</a></li>--}}
{{--                                    <li id="contacts-menu"><a href="{{ route('about') }}#contacts">@lang('navbar.contact')</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <div class="navbar-right search" >--}}
{{--                                <div class="row" >--}}
{{--                                    <form class="navbar-form" role="search" action="{{ route('search') }}" enctype="application/x-www-form-urlencoded">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <input type="text" id="search" class="form-control" placeholder="Search here ..." name="q" @if(!empty($q))value="{{ $q }}" @endif/>--}}
{{--                                            <button type="submit" class="search-btn"></button>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </nav>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</header>
