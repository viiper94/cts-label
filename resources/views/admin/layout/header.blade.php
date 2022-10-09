<header>
    <nav class="navbar navbar-inverse " id="nav">
        <div class="container-fluid">
            <div class="navbar-brand">
                <a href="{{ route('admin') }}"><img src="/assets/img/logo-small.png" alt="Creative technology Studio" class="sticky-logo"/></a>
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
                    <li @if(\Route::is('releases_admin'))class="active" @endif><a href="{{ route('releases_admin') }}">@lang('navbar.releases')</a></li>
                    <li @if(\Route::is('artists.*'))class="active" @endif><a href="{{ route('artists.index') }}">@lang('navbar.artists')</a></li>
                    <li @if(\Route::is('studio_admin'))class="active" @endif><a href="{{ route('studio_admin') }}">@lang('navbar.studio')</a></li>
                    <li @if(\Route::is('school_admin'))class="active" @endif><a href="{{ route('school_admin') }}">@lang('navbar.school')</a></li>
                    <li @if(\Route::is('reviews_admin'))class="active" @endif><a href="{{ route('reviews_admin') }}">@lang('navbar.reviews')</a></li>
                    <li @if(\Route::is('feedback_admin'))class="active" @endif><a href="{{ route('feedback_admin') }}">@lang('navbar.feedback')</a></li>
                    <li @if(\Route::is('emailing'))class="active" @endif><a href="{{ route('channels.index') }}">@lang('navbar.emailing')</a></li>
{{--                    <li @if(\Route::is('users'))class="active" @endif><a href="{{ route('users.index') }}">@lang('navbar.users')</a></li>--}}
                    <li @if(\Route::is('cv.*'))class="active" @endif>
                        <a href="{{ route('cv.index') }}">
                            @lang('navbar.cv')
                            @if($cv_count > 0)
                                <span class="label label-success">{{ $cv_count }}</span>
                            @endif
                        </a>
                    </li>
                    <li><a href="{{ route('home') }}">Вернуться на сайт</a></li>
                </ul>
            </div>
            @yield('search')
        </div>
    </nav>
</header>
