@extends('layout.layout')

@section('title')
    @lang('school.page_title')
@endsection

@section('keywords')
    dj школа, DJ школа Киев, dj school, ди джей школа, ди джей школа Киев, школа, production школа, школа звукорежиссёров,
    школа продюсеров Киев, школа аранжировщиков, курсы DJ Киев, курсы звукорежиссёров, обучение мастерству диджея,
    обучение звукорежиссуре, обучение работе в музыкальных редакторах, обучение созданию электронной музыки,
    курсы аранжировщиков, курс звукорежиссура, курсы саунд продюсеров, обучение protools, частные уроки звукорежиссуры,
    стать dj, курсы звукорежиссуры, курсы продакшн, production, звукорежиссура обучение, обучение диджеингу,
    частные уроки по написанию музыки, продакшн школа Киев, курсы звукорежиссуры, школа аранжировщиков, курсы звукорежиссёров,
    школа аранжировщиков, dj studio, курсы написания электронной музыки, школа написания электронной музыки,
    написание музыки на компьютере, написание музыки, DJ, DJ школа, обучение звукорежиссуре в Киеве,
    обучение звукорежиссуре Киев, звукорежиссер, створення електронної музики, аранжировщик, аранжувальник, курси DJ Київ,
    навчання майстерності діджея, навчання звукорежисурі, електронна музика, курси аранжувальників, курси саунд продюсерів,
    приватні уроки звукорежисури, курси продакшн, приватні уроки з написання музики, написання музики, музика, навчання
    з звукорежисури в Києві, обучение написанию музыки в Киеве, навчання з написання музики в Києві, теория музыки,
    теорія музики, сольфеджіо, сольфеджио, гармония, гармонія, вокал,уроки вокалу, курси вокалу, курсы вокала,
    вокальне мистецтво, вокальное искусство, тренер по вокалу, школа вокала, уроки теории музыки, DJ школа Київ,
    діджей школа, ді джей школа Київ, школа, школа звукорежисерів, школа продюсерів Київ, школа аранжувальників,
    курси DJ Київ, курси звукорежисерів, навчання майстерності діджея, навчання звукорежисурі, навчання роботі в
    музичних редакторах, навчання створенню електронної музики, курси аранжувальників, курс звукорежисура, курси
    саунд продюсерів, навчання protools, приватні уроки звукорежисури, стати dj, курси звукорежисури, курси продакшн,
    звукорежисура навчання, навчання діджеїнгу, приватні уроки з написання музики, продакшн школа Київ, курси звукорежисури,
    школа аранжувальників, курси звукорежисерів, школа аранжувальників, курси написання електронної музики, школа написання
    електронної музики, написання музики на комп\'ютері, написання музики, навчання звукорежисурі в Києві, навчання
    звукорежисурі Київ, звукорежисер, створення електронної музики, аранжувальник, курси DJ Київ, навчання майстерності
    діджея, навчання звукорежісурі, електронна музика, курси аранжувальніків, курси саунд продюсерів, приватні уроки
    звукорежисура, курси продакшн, приватні уроки з написання музики, написання музики, музика, навчання з звукорежисура
    в Києві, навчання написанню музики в Києві, навчання з написання музики в Києві, теорія музики, теорія музики,
    сольфеджіо, гармонія, уроки вокалу, курси вокалу, вокальне мистецтво, тренер з вокалу, школа вокалу,
    уроки теорії музики
@endsection

@section('description', 'Курси DJ, курси звукорежисури, уроки написання музики, курси вокалу, створення музики, написання електронної музики, робота в музичних редакторах, уроки діджеїнгу в Києві.')

@section('meta')
    <meta property="og:locale" content="uk_UA">
    <meta property="og:type" content="website">
    <meta property="og:title" content="CTSchool - професійні курси DJ-їв і саунд продюсерів в Києві">
    <meta property="og:description" content="Навчання майстерності діджея, курси продюсерів і звукорежисерів, написання музики, курси вокалу, сольфеджіо, робота в музичних редакторах">
    <meta property="og:image" content="https://cts-label.com/images/ctschool-y.png">
    <meta property="og:url" content="https://cts-label.com/ctschool.html">
    <meta property="og:site_name" content="CTSchool">
    <link rel="canonical" href="https://cts-label.com/ctschool.html">
@endsection

@section('content')

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Курси звукорежисури і аранжування CTSchool",
      "url" : "https://cts-label.com/ctschool.html",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Kyiv, Ukraine",
        "streetAddress": "Бессарабська площа, 4,"
      },
      "email": "info(at)cts-label.com",

     "telephone": "+38 098 685 40 33"

    }
    </script>

    <div class="school">
        <div class="school-header py-5">
            <div class="container d-flex flex-column flex-md-row justify-content-end align-items-end align-items-md-center py-3">
                <h1 class="me-md-5 mb-0 school-epigraph order-last order-md-first text-center text-md-end">@lang('school.page_header')</h1>
                <div class="lang-switch mb-5 mb-md-0">
                    <div class="btn-group">
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en'])
                           data-lang="en" href="{{ route('school') }}">
                            @lang('shared.en')
                        </a>
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ua' || !isset($_COOKIE['lang'])])
                           data-lang="ua" href="{{ route('school') }}">
                            @lang('shared.ua')
                        </a>
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ru'])
                           data-lang="ru" href="{{ route('school') }}">
                            @lang('shared.ru')
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="studio-nav">
            <div class="container">
                <ul class="d-flex align-items-center justify-content-md-between flex-column flex-md-row py-3 px-0">
                    <li><a href="#about"><span>@lang('school.about_courses')</span></a></li>
                    <li><a href="#equipment"><span>@lang('school.equipment')</span></a></li>
                    <li><a href="#teachers"><span>@lang('school.teachers')</span></a></li>
                    <li><a href="#prices"><span>@lang('school.cost_of_education')</span></a></li>
                    <li><a href="#contact"><span>@lang('school.contact')</span></a></li>
                </ul>
            </div>
        </div>
        <div class="school-content">
            <div class="container py-4">
                <section class="courses py-5">
                    <h2 class="text-center text-uppercase fw-bold mb-5">@lang('school.courses')</h2>
                    <div class="d-flex flex-wrap justify-content-evenly justify-content-xl-between text-uppercase gap-2">
                        <a href="#prices" class="course-button">@lang('school.sound_producer')</a>
                        <a href="#prices" class="course-button">@lang('school.sound_engineer')</a>
                        <a href="#prices" class="course-button">@lang('school.foh_engineer')</a>
                        <a href="#prices" class="course-button">@lang('school.music_theory')</a>
                        <a href="#prices" class="course-button">@lang('school.vocal')</a>
                        <a href="#prices" class="course-button">@lang('school.dj')</a>
                    </div>
                    <div class="marquee overflow-hidden my-5">
                        <div class="marquee-flow d-flex">
                        @for($i = 0; $i < 2; $i++)
                            <span class="d-flex">
                                <img src="/images/school/school-1.webp" height="170" width="145" alt="професійні курси, курси DJ Київ, навчання діджеїнгу">
                                <img src="/images/school/school-2.webp" height="170" width="184" alt="курси вокалу, вокальне мистецтво, тренер з вокалу, школа вокалу">
                                <img src="/images/school/school-3.webp" height="170" width="224" alt="навчання звукорежисурі, курси звукорежисерів, звукорежисура навчання">
                                <img src="/images/school/school-4.webp" height="170" width="223" alt="навчання майстерності діджея, стати dj, курсы DJ Киев">
                                <img src="/images/school/school-5.webp" height="170" width="213" alt="написання музики, створення електронної музики, аранжування">
                                <img src="/images/school/school-6.webp" height="170" width="128" alt="dj школа, DJ школа Киев, dj school, курси саунд продюсерів в Києві">
                            </span>
                        @endfor
                        </div>
                    </div>
                </section>
                <section class="equipment py-5">
                    <h2 class="text-center text-uppercase fw-bold mb-5" id="equipment">@lang('school.equipment')</h2>
                    <div class="row">
                        <div class="col-12 col-sm-6 px-5">
                            <p class="equipment-header text-uppercase py-2 m-auto me-md-5">
                                @lang('school.hardware')
                            </p>
                            <div class="school-equipment-text me-md-5 py-3 m-auto">
                                @lang('school.hardware_text')
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 px-5">
                            <p class="equipment-header text-uppercase py-2 m-auto ms-md-5">
                                @lang('school.software')
                            </p>
                            <div class="school-equipment-text ms-md-5 py-3 m-auto">
                                @lang('school.software_text')
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center py-3">
                            <a href="{{ route('studio') }}#equipment" class="text-center text-decoration-none">@lang('school.check_full_set')</a>
                        </div>
                    </div>
                </section>
                <section class="teachers py-5">
                    <h2 class="text-center text-uppercase fw-bold mb-5" id="teachers">@lang('school.teachers')</h2>
                    <div class="row gy-4 gy-sm-5 gy-md-4">
                        @foreach($teachers as $teacher)
                            <div @class([
                                        'teacher mb-3 col-sm-6',
                                        'col-lg-4' => in_array($loop->iteration, [1,2,3,9,10,11]),
                                        'col-md-6' => in_array($loop->iteration, [4,5,7,8]),
                                        'col-md-12' => $loop->iteration === 6
                                    ])>
                                <div @class([
                                        'm-auto row',
                                        'ms-lg-auto me-lg-3' => in_array($loop->iteration, [4,7]),
                                        'ms-lg-3' => in_array($loop->iteration, [5,8]),
                                    ])>
                                    <div class="col-auto">
                                        <img src="/images/school/teachers/{{ $teacher->image }}" alt="{{ $teacher->name }}" loading="lazy">
                                    </div>
                                    <div class="col">
                                        <p class="teacher-name mb-2 fw-bold">{{ $teacher->name }}</p>
                                        <div class="binfo">{!! $teacher->teacher_binfo !!}</div>
                                        <div class="hinfo">{!! $teacher->teacher_hinfo !!}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
                <section class="about_courses pb-5 pt-3">
                    <h2 class="text-center text-uppercase fw-bold mb-5" id="about">@lang('school.about_courses')</h2>
                    <div class="row">
                        <div class="col-md col-12">
                            <div class="row">
                                <div class="col">
                                    <p class="text-paragraph">@lang('school.about_text')</p>
                                </div>
                                <div class="col-5 d-md-none">
                                    <div class="course-img">
                                        <img src="/images/school/school-9.jpg" class="img-fluid" alt="@lang('school.lesson_holds_sergio')" loading="lazy">
                                        <div class="img-overlay"><p>@lang('school.lesson_holds_sergio')</p></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3 pt-md-0 g-0 g-md-2">
                                <div class="col-6 col-md-4">
                                    <div class="course-img">
                                        <img src="/images/school/school-7.jpg" class="img-fluid" alt="@lang('school.master_class_ekspert')" loading="lazy">
                                        <div class="img-overlay">@lang('school.master_class_ekspert')</div>
                                    </div>
                                </div>
                                <div class="col-md-4 order-last order-md-0 col-12 py-3 py-md-0">
                                    <p>@lang('school.lessons_held')</p>
                                    @lang('school.lessons_held_text')
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="course-img">
                                        <img src="/images/school/school-8.jpg" class="img-fluid" alt="@lang('school.consultation_conducted_by_belyavina')" loading="lazy">
                                        <div class="img-overlay">@lang('school.consultation_conducted_by_belyavina')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto d-none d-md-block">
                            <div class="course-img">
                                <img src="/images/school/school-9.jpg" class="img-fluid" style="width: 233px;" alt="@lang('school.lesson_holds_sergio')" loading="lazy">
                                <div class="img-overlay"><p>@lang('school.lesson_holds_sergio')</p></div>
                            </div>
                        </div>
                    </div>
                    <div class="row py-4">
                        <div class="col-12">
                            <p>@lang('school.about_text_2')</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="row g-0">
                                <div class="course-img mb-md-3 col-6 col-md-12">
                                    <img src="/images/school/school-10.jpg" class="img-fluid" alt="@lang('school.sound_engineering_lesson_shapovalov')" loading="lazy">
                                    <div class="img-overlay">@lang('school.sound_engineering_lesson_shapovalov')</div>
                                </div>
                                <div class="course-img col-6 col-md-12">
                                    <img src="/images/school/school-12.jpg" class="img-fluid" alt="@lang('school.lesson_music_theory_semergey')" loading="lazy">
                                    <div class="img-overlay">@lang('school.lesson_music_theory_semergey')</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex flex-column justify-content-between py-3 py-md-0">
                            <p>* @lang('school.about_text_3')</p>
                            <p>** @lang('school.about_text_4')</p>
                            <p>*** @lang('school.about_text_5')</p>
                            <p class="mb-0">**** @lang('school.about_text_6')</p>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row g-0">
                                <div class="course-img mb-md-3 col-6 col-md-12">
                                    <img src="/images/school/school-11.jpg" class="img-fluid" alt="@lang('school.djing_by_yoshi')" loading="lazy">
                                    <div class="img-overlay">@lang('school.djing_by_yoshi')</div>
                                </div>
                                <div class="course-img col-6 col-md-12">
                                    <img src="/images/school/school-13.jpg" class="img-fluid" alt="@lang('school.production_lesson_by_sergio')" loading="lazy">
                                    <div class="img-overlay">@lang('school.production_lesson_by_sergio')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="services py-5">
                    <h2 class="text-center text-uppercase fw-bold mb-5" id="prices">@lang('school.cost_of_education')</h2>
                    <div class="service-images d-flex justify-content-evenly px-5 flex-wrap">
                        @foreach($courses as $course)
                            <div class="service-item m-3">
                                <button data-bs-toggle="modal" data-bs-target="#service-modal" data-name="{{ $course->name }}"
                                        class="service-link bg-transparent">
                                    <img src="/images/school/courses/{{ $course->image }}" loading="lazy" width="185" height="185"
                                         class="service-image" @if($course->course_alt) alt="{{ $course->course_alt }}" @endif>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </section>
                <section class="contacts pt-5">
                    <h2 class="text-center text-uppercase fw-bold mb-5" id="contact">@lang('school.contact')</h2>
                    <div class="text-center">
                        <p class="mb-4">@lang('school.contact_text_1')</p>
                        <p class="mb-4">@lang('school.contact_text_2')</p>
                        <div class="contact-info">@lang('school.contact_info')</div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="modal fade" id="service-modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="modalLabel">@lang('studio.modal.header')</h3>
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="target" value="school">
                        <div class="form-group mb-3">
                            <label for="service" class="form-label">@lang('studio.modal.service')</label>
                            <input type="text" name="service" id="service" class="form-control form-dark" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">@lang('studio.modal.your_name')*</label>
                            <input type="text" name="name" id="name" class="form-control form-dark" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">@lang('studio.modal.your_email')*</label>
                            <input type="email" name="email" id="email" class="form-control form-dark" required>
                        </div>
                        <div class="form-group">
                            <label for="tel" class="form-label">@lang('studio.modal.your_tel')</label>
                            <input type="tel" name="tel" id="tel" class="form-control form-dark">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>@lang('studio.modal.submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
