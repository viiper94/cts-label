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
    сольфеджіо, гармонія, уроки вокалу, курси вокалу, курси вокалу, вокальне мистецтво, тренер з вокалу, школа вокалу,
    уроки теорії музики
@endsection

@section('description')
    Навчання майстерності діджея, курси продюсерів і звукорежисерів, написання музики, курси вокалу, сольфеджіо, робота в музичних редакторах
@endsection

@section('meta')
    <meta property="og:title" content="CTSchool - професійні курси DJ-їв і саунд продюсерів в Києві">
    <meta property="og:description" content="Навчання майстерності діджея, курси продюсерів і звукорежисерів, написання музики, курси вокалу, сольфеджіо, робота в музичних редакторах">
    <meta property="og:image" content="https://cts-label.com/images/ctschool-y.png">
    <meta property="og:url" content="https://cts-label.com/ctschool.html">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="CTSchool">
@endsection

@section('content')

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Курси звукорежисури і аранжування CTSchool",
      "url" : "https://www.cts-label.com/ctschool.html",
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
            <div class="container py-3">
                <div class="lang-switch align-items-center">
                    <p class="me-5 mb-0 school-epigraph">@lang('school.page_header')</p>
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
                <ul class="py-3 px-0">
                    <li><a href="#about">@lang('school.about_courses')</a></li>
                    <li><a href="#equipment">@lang('school.equipment')</a></li>
                    <li><a href="#teachers">@lang('school.teachers')</a></li>
                    <li><a href="#prices">@lang('school.cost_of_education')</a></li>
                    <li><a href="#contacts">@lang('school.contact')</a></li>
                </ul>
            </div>
        </div>
        <div class="school-content">
            <div class="container py-4">
                <section class="courses py-5">
                    <h1 class="text-center text-uppercase fw-bold mb-5">@lang('school.courses')</h1>
                    <div class="d-flex justify-content-between text-uppercase">
                        <a href="#prices" class="course-button">@lang('school.sound_producer')</a>
                        <a href="#prices" class="course-button">@lang('school.sound_engineer')</a>
                        <a href="#prices" class="course-button">@lang('school.foh_engineer')</a>
                        <a href="#prices" class="course-button">@lang('school.music_theory')</a>
                        <a href="#prices" class="course-button">@lang('school.vocal')</a>
                        <a href="#prices" class="course-button">@lang('school.dj')</a>
                    </div>
                    <div class="marquee overflow-hidden my-5">
                        <div class="marquee-flow d-flex">
                        <span class="d-flex">
                            @for($i = 1; $i < 7; $i++)
                                <img src="/images/school/school-{{ $i }}.jpg">
                            @endfor
                        </span>
                        <span class="d-flex">
                            @for($i = 1; $i < 7; $i++)
                                <img src="/images/school/school-{{ $i }}.jpg">
                            @endfor
                        </span>
                        </div>
                    </div>
                </section>
                <section class="equipment py-5">
                    <h1 class="text-center text-uppercase fw-bold mb-5" id="equipment">@lang('school.equipment')</h1>
                    <div class="row">
                        <div class="col-12 col-sm-6 px-5">
                            <p class="equipment-header text-uppercase py-2 ms-auto me-5">
                                @lang('school.hardware')
                            </p>
                            <div class="equipment-text me-5 ms-auto">
                                @lang('school.hardware_text')
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 px-5">
                            <p class="equipment-header text-uppercase py-2 me-auto ms-5">
                                @lang('school.software')
                            </p>
                            <div class="equipment-text ms-5 me-auto">
                                @lang('school.software_text')
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center py-3">
                            <a href="{{ route('studio') }}#equipment" class="text-center text-decoration-none">@lang('school.check_full_set')</a>
                        </div>
                    </div>
                </section>
                <section class="teachers py-5">
                    <h1 class="text-center text-uppercase fw-bold mb-5" id="teachers">@lang('school.teachers')</h1>
                    <div class="row">
                        @foreach($teachers as $teacher)
                            <div @class([
                                        'col-md-4 col-sm-6 col-xs-12 teacher row mb-5',
                                        'offset-md-2' => $loop->iteration === 4 || $loop->iteration === 7,
                                        'offset-md-4' => $loop->iteration === 6,
                                    ])>
                                <div class="col-auto">
                                    <img src="/images/school/teachers/{{ $teacher->image }}">
                                </div>
                                <div class="col">
                                    <p class="teacher-name mb-2 fw-bold">{{ $teacher->name }}</p>
                                    <div class="binfo">{!! $teacher->teacher_binfo !!}</div>
                                    <div class="hinfo">{!! $teacher->teacher_hinfo !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
                <section class="about_courses pb-5 pt-3">
                    <h1 class="text-center text-uppercase fw-bold mb-5" id="about_courses">@lang('school.about_courses')</h1>
                    <div class="row">
                        <div class="col">

                        </div>
                        <div class="col-auto">
                            <div class="course-img course-img2">
                                <img src="/assets/img/school-9.jpg" class="img-fluid">
                                <div class="img-overlay">@lang('school.lesson_holds_sergio')</div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>


    <div class="col-xs-12 school-page">

        <div class="container">

                <h2 class="text-center sh" id="about">@lang('school.about_courses')</h2>
                <div class="text">
                    <div class="row">
                        <p class="pull-left text-paragraph">@lang('school.about_text')</p>
                        <div class="course-img course-img2 pull-right">
                            <img src="/assets/img/school-9.jpg" class="img-responsive">
                            <div class="img-overlay">@lang('school.lesson_holds_sergio')</div>
                        </div>
                        <div class="clearfix hidden-md hidden-lg hidden-sm visible-xs"></div>
                        <div class="course-img course-img1 pull-left">
                            <img src="/assets/img/school-7.jpg" class="img-responsive">
                            <div class="img-overlay">@lang('school.master_class_ekspert')</div>
                        </div>
                        <div class="course-img course-img1 pull-right">
                            <img src="/assets/img/school-8.jpg" class="img-responsive">
                            <div class="img-overlay">@lang('school.consultation_conducted_by_belyavina')</div>
                        </div>
                        <div class="course-list">
                            <h5 style="padding-bottom: 15px;">@lang('school.lessons_held')</h5>
                            @lang('school.lessons_held_text')
                        </div>
                    </div>
                    <div class="row">
                        <p style="margin-bottom: 30px;">@lang('school.about_text_2')</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4 course-img-block pull-left">
                            <div class="course-img course-img3">
                                <img src="/assets/img/school-10.jpg" class="img-responsive">
                                <div class="img-overlay">@lang('school.sound_engineering_lesson_shapovalov')</div>
                            </div>
                            <div class="course-img course-img3">
                                <img src="/assets/img/school-12.jpg" class="img-responsive">
                                <div class="img-overlay">@lang('school.lesson_music_theory_semergey')</div>
                            </div>
                        </div>
                        <div class="col-md-4 course-center-text">

                            <p>* @lang('school.about_text_3')</p>
                            <p>** @lang('school.about_text_4')</p>
                            <p>*** @lang('school.about_text_5')</p>
                            <p>**** @lang('school.about_text_6')</p>
                        </div>
                        <div class="col-md-4 course-img-block pull-right">
                            <div class="course-img course-img3">
                                <img src="/assets/img/school-11.jpg" class="img-responsive">
                                <div class="img-overlay">@lang('school.djing_by_yoshi')</div>
                            </div>
                            <div class="course-img course-img3">
                                <img src="/assets/img/school-13.jpg" class="img-responsive">
                                <div class="img-overlay">@lang('school.production_lesson_by_sergio')</div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="text-center sh" id="prices">@lang('school.cost_of_education')</h2>
                <div class="service-images ">
                    @foreach($courses as $course)
                        <div class="col-md-3 col-sm-6 text-center">
                            <a href="mailto:info@cts-label.com?@lang('school.mail_body'). {{ $course->name ?? "" }}">
                                <img src="/images/school/courses/{{ $course->image }}"
                                     class="service-image" @if($course->course_alt) alt="{{ $course->course_alt }}"@endif>
                            </a>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
                <h2 class="text-center sh" id="contacts">@lang('school.contact')</h2>
                <div class="text-center col-xs-12">
                    <p>@lang('school.contact_text_1')</p><br>
                    <p>@lang('school.contact_text_2')</p><br>
                    <div class="contact-info">@lang('school.contact_info')</div>
                </div>
            </div>
        </div>
    </div>
@endsection
