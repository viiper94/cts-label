<nav>
    <div class="container-fluid d-flex d-md-none fixed-top bg-dark shadow">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar" aria-controls="navbar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a href="{{ route('releases.index') }}" class="d-flex text-decoration-none p-3 m-auto">
            <b class="fs-5">@lang('shared.admin.sidebar.header')</b>
        </a>
    </div>
    <div class="sidebar text-bg-dark p-3 offcanvas-md offcanvas-start" tabindex="-1" id="navbar" aria-labelledby="navbarLabel">
        <a href="{{ route('releases.index') }}" class="d-flex text-decoration-none ps-3">
            <b class="fs-5">@lang('shared.admin.sidebar.header')</b>
        </a>
        <hr>
        @include('admin.layout.search')
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('releases.index') }}" @class(['nav-link', 'active' => \Route::is('releases.*')])><i class="fa-solid fa-compact-disc me-2"></i>@lang('shared.admin.sidebar.releases')</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tracks.index') }}" @class(['nav-link', 'active' => \Route::is('tracks.*')])><i class="fa-solid fa-music me-2"></i>@lang('shared.admin.sidebar.tracks')</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('artists.index') }}" @class(['nav-link', 'active' => \Route::is('artists.*')])><i class="fa-solid fa-users me-2"></i>@lang('shared.admin.sidebar.artists')</a>
                <ul>
                    <li>
                        <a href="{{ route('artists_cv.index') }}" @class(['nav-link', 'active' => \Route::is('artists_cv.*')])>
                            <i class="fa-solid fa-file-lines me-2"></i>@lang('shared.admin.sidebar.artists_cv')
                            @if($artists_cv_count > 0)
                                <span class="badge bg-danger">{{ $artists_cv_count }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('studio.index') }}" @class(['nav-link', 'active' => \Route::is('studio.*')])><i class="fa-solid fa-microphone me-2"></i>@lang('shared.admin.sidebar.ctstudio')</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('school.courses.index') }}" class="nav-link"><i class="fa-solid fa-building-columns me-2"></i>@lang('shared.admin.sidebar.ctschool')</a>
                <ul>
                    <li>
                        <a href="{{ route('school.courses.index') }}" @class(['nav-link', 'active' => \Route::is('school.courses.*')])>
                            <i class="fa-solid fa-graduation-cap me-2"></i>@lang('shared.admin.sidebar.ctschool_courses')
                        </a>
                        <a href="{{ route('school.teachers.index') }}" @class(['nav-link', 'active' => \Route::is('school.teachers.*')])>
                            <i class="fa-solid fa-chalkboard-user me-2"></i>@lang('shared.admin.sidebar.ctschool_teachers')
                        </a>
                        <a href="{{ route('school.cv.index') }}" @class(['nav-link', 'active' => \Route::is('school.cv.*')])>
                            <i class="fa-solid fa-file-lines me-2"></i>@lang('shared.admin.sidebar.ctschool_cv')
                            @if($school_cv_count > 0)
                                <span class="badge bg-danger">{{ $school_cv_count }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('feedback.index') }}" @class(['nav-link', 'active' => \Route::is('feedback.*')])>
                    <i class="fa-solid fa-comments me-2"></i>@lang('shared.admin.sidebar.feedbacks')
                    @if($feedback_results_count > 0)
                        <span class="badge bg-danger">{{ $feedback_results_count }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('emailing.channels.index') }}" class="nav-link"><i class="fa-solid fa-envelope me-2"></i>@lang('shared.admin.sidebar.emailing')</a>
                <ul>
                    <li>
                        <a href="{{ route('emailing.channels.index') }}" @class(['nav-link', 'active' => \Route::is('emailing.channels.*')])><i class="fa-solid fa-database me-2"></i>@lang('shared.admin.sidebar.emailing_channels')</a>
                        <a href="{{ route('emailing.contacts.index') }}" @class(['nav-link', 'active' => \Route::is('emailing.contacts.*')])><i class="fa-solid fa-address-book me-2"></i>@lang('shared.admin.sidebar.emailing_contacts')</a>
                        <a href="{{ route('emailing.queue.index') }}" @class(['nav-link', 'active' => \Route::is('emailing.queue.*')])>
                            <i class="fa-solid fa-hourglass me-2"></i>@lang('shared.admin.sidebar.emailing_queue')
                            @if($queue_count !== 0)
                                <span @class([
                                    'badge',
                                    'bg-warning text-dark' => $queue_sent !== $queue_count,
                                    'bg-success' => $queue_sent === $queue_count
                                ])>{{ $queue_sent }}/{{ $queue_count }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <hr>
        <div class="lang-switch">
            <div class="btn-group">
                <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en'])
                   data-lang="en" href="{{ url()->current() }}">
                    @lang('shared.en')
                </a>
                <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ru'])
                   data-lang="ru" href="{{ url()->current() }}">
                    @lang('shared.ru')
                </a>
                <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ua' || !isset($_COOKIE['lang'])])
                   data-lang="ua" href="{{ url()->current() }}">
                    @lang('shared.ua')
                </a>
            </div>
        </div>
        <hr>
        <a href="{{ route('home') }}" class="text-decoration-none fw-bold"><i class="fa-solid fa-house me-2"></i>@lang('shared.admin.sidebar.to_website')</a>
    </div>
</nav>
