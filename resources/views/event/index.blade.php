@extends('layout.layout')

@section('title', 'Маркетинг і менеджмент артиста в кризові часи | Вебінар CTS Records')

@section('content')

    <div class="container event py-5">

        <h1>Маркетинг і менеджмент артиста в кризові часи</h1>
        <div class="row my-5 py-5">
            <h2 class="mb-4">Про вебінар</h2>
            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda consectetur cupiditate delectus
                deleniti exercitationem impedit ipsam, magnam nemo obcaecati odit officia provident quasi reiciendis similique sit tempore velit voluptate.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda consectetur cupiditate delectus
                deleniti exercitationem impedit ipsam, magnam nemo obcaecati odit officia provident quasi reiciendis similique sit tempore velit voluptate.
                <br>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda consectetur cupiditate delectus
                deleniti exercitationem impedit ipsam, magnam nemo obcaecati odit officia provident quasi reiciendis similique sit tempore velit voluptate.</p>
        </div>

        <div class="row my-5 py-5">
            <h2 class="mb-4">Спікери</h2>
            <div class="d-flex gap-3 justify-content-evenly flex-wrap">
                @for($i = 0; $i < 3; $i++)
                    <div class="card text-bg-dark speaker">
                        <img src="/images/school/courses/default.png" alt="" class="">
                        <div class="card-body">
                            <h5 class="card-title">Speaker Name</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda dicta doloribus error
                                libero quo quod rem voluptate. </p>
                            <button class="btn btn-outline-primary">
                                Більше інформації
                            </button>
                            <a href="#" class="btn btn-outline">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="row my-5 py-5">
            <h2 class="mb-4">Розклад</h2>
            <h5 class="text-center">Дата: 15 лютого, 2023 року</h5>
            <h5 class="text-center">Місце: <a href="#">Zoom за посиланням</a></h5>
            <div class="row pt-3 mt-3">
                <div class="col-2">
                    <h4 class="text-end">11.00</h4>
                </div>
                <div class="col">
                    <b>Початок вебінару</b>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-2">
                    <h4 class="text-end">11.00 - 13.30</h4>
                </div>
                <div class="col">
                    <span>
                        <b>Speaker Name</b> -
                        Topic Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, est.
                    </span>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-2">
                    <h4 class="text-end">13.30 - 15.00</h4>
                </div>
                <div class="col">
                    <span>
                        <b>Speaker Name</b> -
                        Topic Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad facere fugit nemo nisi soluta, unde..
                    </span>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-2">
                    <h4 class="text-end">15.00 - 16.30</h4>
                </div>
                <div class="col">
                    <span>
                        <b>Speaker Name</b> -
                        Topic Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt ipsum qui ratione ut?.
                    </span>
                </div>
            </div>
            <div class="row pt-3 ">
                <div class="col-2">
                    <h4 class="text-end">16.30 - 17.00</h4>
                </div>
                <div class="col">
                    <b>Фінальне слово</b>
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

