<header class="pt-2 pb-3">
    <div class="container text-center text-lg-start">
        <a href="{{ route('home') }}" class="d-block">
            <img src="/assets/img/logo.png" class="logo" alt="Creative Technology Studio"/>
        </a>
    </div>
    <nav class="navbar navbar-expand-lg pb-0" id="main_nav">
        <div class="container">
            <div class="w-100 d-flex d-lg-none justify-content-between my-lg-0 my-2">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <form class="search search-small">
                    <input class="form-control form-dark" type="text" placeholder="Search here ..." name="q" value="{{ Request::input('q') }}">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <a class="navbar-brand me-0" href="{{ route('home') }}">
                    <img src="/assets/img/logo-small.png" alt="Creative technology Studio" class="sticky-logo"/>
                </a>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => \Route::is('home')]) href="{{ route('home') }}">@lang('navbar.home')</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => \Route::is('about')]) href="{{ route('about') }}" id="about-menu">@lang('navbar.about')</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => \Route::is('artists')]) href="{{ route('artists') }}">@lang('navbar.artists')</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => \Route::is('studio')]) href="{{ route('studio') }}">@lang('navbar.studio')</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => \Route::is('school.*')]) href="{{ route('school') }}">@lang('navbar.school')</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => \Route::is('reviews')]) href="{{ route('reviews') }}">@lang('navbar.reviews')</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link']) href="{{ route('about', '#demo') }}" id="demo-menu">@lang('navbar.demo')</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link']) href="{{ route('about', '#contacts') }}" id="contacts-menu">@lang('navbar.contact')</a>
                    </li>
                </ul>
                <form class="d-none d-lg-flex search">
                    <input class="form-control form-dark" type="text" placeholder="Search here ..." name="q" value="{{ Request::input('q') }}">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
    </nav>
</header>
