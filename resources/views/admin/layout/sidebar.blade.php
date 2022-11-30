<nav>
    <div class="container-fluid d-flex d-md-none fixed-top bg-dark shadow">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar" aria-controls="navbar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a href="{{ route('releases.index') }}" class="d-flex text-decoration-none p-3 m-auto">
            <b class="fs-5">CTS Admin Panel</b>
        </a>
    </div>
    <div class="sidebar text-bg-dark p-3 offcanvas-md offcanvas-start" tabindex="-1" id="navbar" aria-labelledby="navbarLabel">
        <a href="{{ route('releases.index') }}" class="d-flex text-decoration-none ps-3">
            <b class="fs-5">CTS Admin Panel</b>
        </a>
        <hr>
        @include('admin.layout.search')
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('releases.index') }}" @class(['nav-link', 'active' => \Route::is('releases.*')])><i class="fa-solid fa-music me-2"></i>Релизы</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('artists.index') }}" @class(['nav-link', 'active' => \Route::is('artists.*')])><i class="fa-solid fa-users me-2"></i>Артисты</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('studio.index') }}" @class(['nav-link', 'active' => \Route::is('studio.*')])><i class="fa-solid fa-microphone me-2"></i>CTStudio</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('school.courses.index') }}" class="nav-link"><i class="fa-solid fa-building-columns me-2"></i>CTShool</a>
                <ul>
                    <li>
                        <a href="{{ route('school.courses.index') }}" @class(['nav-link', 'active' => \Route::is('school.courses.*')])><i class="fa-solid fa-graduation-cap me-2"></i>Курси школы</a>
                        <a href="{{ route('school.teachers.index') }}" @class(['nav-link', 'active' => \Route::is('school.teachers.*')])><i class="fa-solid fa-chalkboard-user me-2"></i>Преподаватели</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('reviews.index') }}" @class(['nav-link', 'active' => \Route::is('reviews.*')])><i class="fa-solid fa-star me-2"></i>Ревью</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('feedback.index') }}" @class(['nav-link', 'active' => \Route::is('feedback.*')])><i class="fa-solid fa-comments me-2"></i>Фидбеки</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('emailing.channels.index') }}" class="nav-link"><i class="fa-solid fa-envelope me-2"></i>Рассылки</a>
                <ul>
                    <li>
                        <a href="{{ route('emailing.channels.index') }}" @class(['nav-link', 'active' => \Route::is('emailing.channels.*')])><i class="fa-solid fa-database me-2"></i>Каналы</a>
                        <a href="{{ route('emailing.contacts.index') }}" @class(['nav-link', 'active' => \Route::is('emailing.contacts.*')])><i class="fa-solid fa-address-book me-2"></i>Контакты</a>
                        <a href="{{ route('emailing.queue.index') }}" @class(['nav-link', 'active' => \Route::is('emailing.queue.*')])>
                            <i class="fa-solid fa-hourglass me-2"></i>Очередь
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
            <li class="nav-item">
                <a href="{{ route('cv.index') }}" @class(['nav-link', 'active' => \Route::is('cv.*')])>
                    <i class="fa-solid fa-file-lines me-2"></i>Анкеты
                    @if($cv_count > 0)
                        <span class="badge bg-danger">{{ $cv_count }}</span>
                    @endif
                </a>
            </li>
        </ul>
        <hr>
        <a href="{{ route('home') }}" class="text-decoration-none fw-bold"><i class="fa-solid fa-house me-2"></i>Вернуться на сайт</a>
    </div>
</nav>
