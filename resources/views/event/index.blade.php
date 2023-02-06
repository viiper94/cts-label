@extends('layout.layout')

@section('title', 'Маркетинг і менеджмент артиста в кризові часи | Вебінар CTS Records')

@section('content')

    <div class="event-header py-3">
        <div class="container py-5">
            <h1>Маркетинг і менеджмент артиста в кризові часи</h1>
        </div>
    </div>

    <div class="container event py-5">

        <div class="row mb-5 py-5">
            <h2 class="mb-4">Про вебінар</h2>
            <p class="mb-0 mx-auto" style="max-width: 800px">Цей вебінар спрямований на розширення можливостей музикантів та артистів, які продовжують свою
                творчу діяльність під час війни. Проект «Маркетинг і менеджмент артиста в кризові часи» призваний допомогти
                українським митцям втілити свої творчі проекти та знайти додаткові джерела фінансування під час війни.
                Вебінар буде цікавий також звукорежисери, музичним менеджерам, арт-менеджерам та іншим діячам творчої сфери
                з питань, промоції та монетизації музичних творів. Подія проходить за підтримки Гете Інститут.
                Спікери поділяться з аудиторією власним досвідом та вже реалізованими кейсами та дадуть відповіді на питання.</p>
        </div>

        <div class="d-flex align-items-center justify-content-center my-5 py-5">
            <button class="btn-primary btn btn-lg" data-bs-toggle="modal" data-bs-target="#event-modal">
                <i class="fa-solid fa-ticket me-2"></i>
                Зарееструватись на вебінар
            </button>
        </div>

        <section class="my-5 py-5">
            <h2 class="mb-4">Спікери</h2>

            <div class="card text-bg-dark speaker mb-5">
                <div class="row g-0">
                    <div class="col-4 col-md-3 bg-img" style="background-image: url('/images/event/Lilia_lazareva.png')"></div>
                    <div class="col-8 col-md-9 card-body d-flex flex-column">
                        <h5 class="card-title">ЛІЛІЯ ЛАЗАРЄВА</h5>
                        <p class="flex-grow-1">Арт менеджерка, співзасновниця рекорд лейблу та студії звукозапису CTS Records,
                            лекторка, експерторка сфери музичного маркетингу та менеджменту.</p>
                        <div class="btns">
                            <a href="#" class="btn btn-outline">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card text-bg-dark speaker mb-5">
                <div class="row g-0">
                    <div class="col-4 col-md-3 bg-img" style="background-image: url('/images/event/denys_vasylev.png')"></div>
                    <div class="col-8 col-md-9 card-body d-flex flex-column">
                        <h5 class="card-title">ДЕНИС ВАСИЛЬЄВ</h5>
                        <p class="flex-grow-1">Музикант, автор композитор Performing Right Society (PRS) UK. Лауреат
                            першої премії фестивалю «Червона Рута» 2017 року в жанрі інструментальний фольклор. Продюсер
                            музичного проєкту “Barabanza” (Гурт /Школа /Музей). Арт директор міжнародної музичної
                            резиденції SoundArtSpace. Експерт проєктів EU4Culture/House of Europe.</p>
                        <div class="btns">
                            <a href="#" class="btn btn-outline">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card text-bg-dark speaker mb-5">
                <div class="row g-0">
                    <div class="col-4 col-md-3 bg-img" style="background-image: url('/images/event/sergio.png')"></div>
                    <div class="col-8 col-md-9 card-body d-flex flex-column">
                        <h5 class="card-title">СЕРГІЙ ЛАЗАРЄВ a.k.a. SERGIO MEGA</h5>
                        <p><i>модератор вебінару</i></p>
                        <p class="flex-grow-1">Музикант, композитор, продюсер, експерт мистецьких і культурних проектів,
                            співзасновник лейблу та студії звукозапису CTS Records, кандидат мистецтвознавства,
                            доцент кафедри кіно-, телемистецтва КНУКіМ.</p>
                        <div class="btns">
                            <a href="#" class="btn btn-outline">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <div class="row my-5 py-5">
            <h2 class="mb-5">Програма вебінару</h2>
            <div class="wrapper">
                <div class="row mb-4">
                    <h5>ЛІЛІЯ ЛАЗАРЄВА</h5>
                    <ul>
                        <li>Грантові програми для українських митців, діячів музичної сфери.</li>
                        <li>Участь у фестивалях та шоукейсах.</li>
                    </ul>
                </div>
                <div class="row mb-4">
                    <h5>ДЕНИС ВАСИЛЬЄВ</h5>
                    <ul>
                        <li>Створення міжнародних культурних проєктів. Особливості їх менеджменту.</li>
                        <li>Міжнародні музичні резиденції. Що це таке і навіщо в них брати участь.</li>
                        <li>Робота автора с ОКУ.</li>
                    </ul>
                </div>
                <div class="row mb-4">
                    <h5>СЕРГІЙ ЛАЗАРЄВ a.k.a. SERGIO MEGA</h5>
                    <ul>
                        <li>Сучасні технології просування музичних творів.</li>
                        <li>Видання музичних творів – практичні поради.</li>
                    </ul>
                </div>
                <div class="row">
                    <h5>ПИТАННЯ ТА ВІДПОВІДІ</h5>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-center my-5 pt-5">
            <button class="btn-primary btn btn-lg" data-bs-toggle="modal" data-bs-target="#event-modal">
                <i class="fa-solid fa-ticket me-2"></i>
                Зарееструватись на вебінар
            </button>
        </div>

    </div>

    <div class="modal fade" id="event-modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="modalLabel">Реестрація на вебінар</h3>
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="register">
                        @csrf
                        <input type="hidden" name="target" value="school">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Ім'я, Прізвище*</label>
                            <input type="text" name="name" id="name" class="form-control form-dark" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">E-mail*</label>
                            <input type="email" name="email" id="email" class="form-control form-dark" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tel" class="form-label">Контактний телефон*</label>
                            <input type="tel" name="tel" id="tel" class="form-control form-dark" required>
                        </div>
                        <div class="form-check pt-3">
                            <input class="form-check-input" type="radio" name="type" value="артист/музикант" id="artist" required>
                            <label class="form-check-label" for="artist">
                                Артист/музикант
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="менеджер артиста" id="manager" required>
                            <label class="form-check-label" for="manager">
                                Менеджер артиста
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="звукорежисер" id="sound_engineer" required>
                            <label class="form-check-label" for="sound_engineer">
                                Звукорежисер
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="студент/випускник CTSchool" id="ctschool_student" required>
                            <label class="form-check-label" for="ctschool_student">
                                Студент/випускник CTSchool
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="студент КНУКіМ/КУК" id="student_knukim" required>
                            <label class="form-check-label" for="student_knukim">
                                Студент КНУКіМ/КУК
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="звукорежисер" id="student_nakkim" required>
                            <label class="form-check-label" for="student_nakkim">
                                Студент НАКККіМ
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="звукорежисер" id="teacher" required>
                            <label class="form-check-label" for="teacher">
                                Викладач
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="інше" id="other" required>
                            <label class="form-check-label" for="other">
                                Інше
                            </label>
                        </div>
                        <div class="form-group mb-3" style="display: none" id="if_other">
                            <input type="text" name="other" class="form-control form-dark">
                        </div>
                        <div class="form-group my-3">
                            <label for="additional" class="form-label">Додаткова інформація, яку ви хотіли б нам повідомити</label>
                            <textarea name="additional" id="additional" class="form-control form-dark"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="register" type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>Зарееструватися</button>
                </div>
            </div>
        </div>
    </div>

@endsection

