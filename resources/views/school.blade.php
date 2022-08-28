@extends('layout.layout')

@section('assets')
    <link href="/assets/css/ctssc2.css" rel="stylesheet">
    <link  href="/assets/css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="/assets/js/modernizr.js"></script>
@endsection

@section('title')
    @lang('school.page_header')
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
    CTSchool - професійна школа DJ та саунд продюсерів у Києві. Курси DJ, курси продюсерів, курси діджеїв, курси звукорежисерів; курси написання електронної музики. Школа DJ, школа продюсерів, курси саунд продюсерів,  школа діджеїв, школа звукорежисерів, курси вокалу. Навчання майстерності діджея, сольфеджіо, навчання роботі в музичних редакторах, уроки теорії музики, навчання електронної музики, навчання protools, навчання reason
@endsection

@section('meta')
    <meta property="og:title" content="CTSchool - професійні курси звукорежисерів, аранжувальників, DJ-їв і саунд продюсерів в Києві">
    <meta property="og:description" content="CTSchool - професійна школа DJ та продюсерів у Києві. Курси DJ, курси продюсерів. Навчання майстерності діджея, навчання роботі в музичних редакторах, створення електронної музики, dj школа, курси аранжувальників, курси звукорежисерів, курси написання електронної музики. Школа DJ, школа продюсерів, курси саунд продюсерів, школа діджеїв, школа звукорежисерів, курси вокалу. Навчання майстерності діджея, сольфеджіо, навчання роботі в музичних редакторах, уроки теорії музики, навчання електронної музики, навчання protools, навчання reason">
    <meta property="og:image" content="https://cts-label.com/assets/img/ctschool-y.png">
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
    <div class="col-xs-12 school-page">
        <div class="row">
            <div class="col-xs-12 s-logo">
                <div class="container">
                    <img src="/assets/img/ctschool-y.png" alt="CTSchool">
                    <div class="pull-right">
                        <div class="text-right switch-btns" style="padding-right:18px;">
                            <a class="switch-btn pull-right @if(isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en') active @endif"
                               data-lang="en" href="{{!$_SERVER['QUERY_STRING'] ? '' : '?'.$_SERVER['QUERY_STRING']}}">
                                @lang('shared.en')
                            </a>
                            <a class="switch-btn pull-right @if(isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ru') active @endif"
                               data-lang="ru" href="{{!$_SERVER['QUERY_STRING'] ? '' : '?'.$_SERVER['QUERY_STRING']}}">
                                @lang('shared.ru')
                            </a>
                            <a class="switch-btn pull-right @if((isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ua') || !isset($_COOKIE['lang'])) active @endif"
                               data-lang="ua" href="{{!$_SERVER['QUERY_STRING'] ? '' : '?'.$_SERVER['QUERY_STRING']}}">
                                @lang('shared.ua')
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-6 pull-right">
                        <h1>@lang('school.page_header')</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="school-menu school-land">
                <div class="container">
                    <ul class="list-unstyled s-menu">
                        <li><a href="#about">@lang('school.about_courses')</a></li>
                        <li><a href="#equipment">@lang('school.equipment')</a></li>
                        <li><a href="#teachers">@lang('school.teachers')</a></li>
                        <li><a href="#prices">@lang('school.cost_of_education')</a></li>
                        <li><a href="#contacts">@lang('school.contact')</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="container">
            <h2 class="sh text-center" id="courses">@lang('school.courses')</h2>
            <div class="сol-xs-12 course-buttons text-center">
                <div class="course-button l1 hover_one">@lang('school.sound_producer')</div>
                <div class="course-button l2 hover_two">@lang('school.sound_engineer')</div>
                <div class="course-button l2 hover_three">@lang('school.foh_engineer')</div>
                <div class="course-button l2 hover_four">@lang('school.music_theory')</div>
                <div class="course-button l2 hover_five">@lang('school.vocal')</div>
                <div class="course-button l1b hover_six">@lang('school.dj')</div>
            </div>
            <div class="clearfix"></div>
            <div class="school-images">
                <section class="b-marquee-line">
                    <div class="b-marquee-line__flow">
                        <div class="b-marquee-line__flow-in">
                            <span class="b-marquee-line__flow-block">
                                @for($i = 1; $i < 7; $i++)
                                    <img src="/assets/img/school-{{ $i }}.jpg" class="pull-left">
                                @endfor
                            </span>
                            <span class="b-marquee-line__flow-block">
                                @for($i = 1; $i < 7; $i++)
                                    <img src="/assets/img/school-{{ $i }}.jpg" class="pull-left">
                                @endfor
						    </span>
                        </div>
                    </div>
                </section>
                <div class="clearfix"></div>
            </div>
            <h2 class="text-center sh" id="equipment">@lang('school.equipment')</h2>
            <div class="col-xs-12">
                <div class="col-md-3 col-md-offset-3 col-sm-4 grey-text hrdw">
                    <div class="row">
                        <div class="bordered" style="text-transform:uppercase;">@lang('school.hardware')</div>
                        @lang('school.hardware_text')
                    </div>
                </div>
                <div class="col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-4 grey-text hrdw">
                    <div class="row">
                        <div class="bordered" style="text-transform:uppercase;">@lang('school.software')</div>
                        @lang('school.software_text')
                    </div>
                </div>
                <div class="col-sm-4 col-sm-offset-4 text-center">
                    <p><a href="{{ route('studio') }}#equipment">@lang('school.check_full_set')</a></p>
                </div>
                <div class="clearfix"></div>
                <h2 class="text-center sh" id="teachers">@lang('school.teachers')</h2>
                <div class="teachers">
                    <div class="row">
                        @foreach($teachers as $teacher)
                            <div class="col-md-4 @if($loop->iteration === 4 || $loop->iteration === 7) col-md-offset-2 @endif
                                @if($loop->iteration === 6) col-md-offset-4 @endif col-sm-6 col-xs-12 teacher">
                                <img src="/images/school/teachers/{{ $teacher->image }}">
                                <b>{{ $teacher->name }}</b>
                                <div class="binfo">{!! $teacher->teacher_binfo !!}</div>
                                <div class="hinfo">{!! $teacher->teacher_hinfo !!}</div>
                            </div>
                            @if($loop->iteration === 3 || $loop->iteration === 8)
                                <div class="clearfix visible-md visible-lg hidden-sm hidden-xs"></div>
                            @endif
                            @if($loop->iteration % 2 === 0)
                                <div class="clearfix visible-sm"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
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
