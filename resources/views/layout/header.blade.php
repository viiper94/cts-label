<header>
    <div class="container">
        <div class="col-xs-12 logo-container">
            <div class="row">
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
        </div>
    </div>
    <div class="black" id="main_nav">
        <div class="container">
            <div class="col-xs-12">
                <div class="row">
                    <nav class="navbar navbar-default" id="nav">
                        <div class="container-fluid">
                            <div class="navbar-brand">
                                <a href="/"><img src="/assets/img/logo-small.png" alt="Creative technology Studio" class="sticky-logo"/></a>
                            </div>
                            <div class="navbar-header navbar-left">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu-collapse" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse navbar-left" id="main-menu-collapse">
                                <ul class="nav navbar-nav">
                                    <li @if(\Route::is('home'))class="active" @endif><a href="{{ route('home') }}">@lang('navbar.home')</a></li>
                                    <li @if(\Route::is('about'))class="active" @endif id="about-menu"><a href="{{ route('about') }}">@lang('navbar.about')</a></li>
                                    <li @if(\Route::is('artists'))class="active" @endif><a href="{{ route('artists') }}">@lang('navbar.artists')</a></li>
                                    <li @if(\Route::is('studio'))class="active" @endif><a href="{{ route('studio') }}">@lang('navbar.studio')</a></li>
                                    <li @if(\Route::is('school'))class="active" @endif><a href="{{ route('school') }}">@lang('navbar.school')</a></li>
                                    <li @if(\Route::is('reviews'))class="active" @endif><a href="{{ route('reviews') }}">@lang('navbar.reviews')</a></li>
                                    <li id="demo-menu"><a href="{{ route('about') }}#demo">@lang('navbar.demo')</a></li>
                                    <li id="contacts-menu"><a href="{{ route('about') }}#contacts">@lang('navbar.contact')</a></li>
                                </ul>
                            </div>
                            <div class="navbar-right search" >
                                <div class="row" >
                                    <form class="navbar-form" role="search" action="{{ route('search') }}" enctype="application/x-www-form-urlencoded">
                                        <div class="form-group">
                                            <input type="text" id="search" class="form-control" placeholder="Search here ..." name="q" @if(!empty($q))value="{{ $q }}" @endif/>
                                            <button type="submit" class="search-btn"></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
