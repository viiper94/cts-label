@extends('layout.layout')

@section('assets')
    <link href="/assets/css/ctssc2.css" rel="stylesheet" />
    <link  href="/assets/css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="/assets/js/modernizr.js"></script>
@endsection

@section('content')
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "Cтудия звукозаписи CTS Records",
      "url" : "http://www.cts-label.com/studio.html",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Kiev, Ukraine",
        "streetAddress": "Бессарабська площа, 4,"
      },
      "email": "info(at)cts-label.com",
      "telephone": "+38 098 685 40 33"
    }
    </script>
    <div class="col-xs-12 studio-page">
        <div class="row">
            <div class="col-xs-12 s-logo">
                <div class="container">
                    <img src="/assets/img/cts-studio-y.png" alt="CTStudio">
                    <div class="pull-right">
                        <div class="text-right switch-btns" style="padding-right:18px;">
                            <a class="switch-btn pull-right @if($_COOKIE['lang'] === 'en') active @endif" data-lang="en" href="{{!$_SERVER['QUERY_STRING'] ? '' : '?'.$_SERVER['QUERY_STRING']}}">@lang('shared.en')</a>
                            <a class="switch-btn pull-right @if($_COOKIE['lang'] === 'ru') active @endif" data-lang="ru" href="{{!$_SERVER['QUERY_STRING'] ? '' : '?'.$_SERVER['QUERY_STRING']}}">@lang('shared.ru')</a>
                            <a class="switch-btn pull-right @if($_COOKIE['lang'] === 'ua') active @endif" data-lang="ua" href="{{!$_SERVER['QUERY_STRING'] ? '' : '?'.$_SERVER['QUERY_STRING']}}">@lang('shared.ua')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="school-menu studio-land">
                    <div class="container">
                        <ul class="nav-justified list-unstyled s-menu studio-menu">
                            <li><a href="#equipment">@lang('studio.equipment')</a></li>
                            <li><a href="#services">@lang('studio.services')</a></li>
                            <li><a href="#projects">@lang('studio.projects')</a></li>
                            <li><a href="#contacts">@lang('studio.contacts')</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="container">
                <div class="text col-xs-12 col-md-12" style="margin-top: 60px;">
                    <div class="row">@lang('studio.top_text')</div>
                </div>
                <div class="studio-images ">
                    <section class="b-marquee-line">
                        <div class="b-marquee-line__flow">
                            <div class="b-marquee-line__flow-in">
                                <span class="b-marquee-line__flow-block">
                                    @for($i = 1; $i <= 8; $i++)
                                       <img src="/assets/img/studio-{{ $i }}.jpg" class="pull-left" />
                                    @endfor
                                </span>
                                <span class="b-marquee-line__flow-block">
                                    @for($i = 1; $i <= 8; $i++)
                                        <img src="/assets/img/studio-{{ $i }}.jpg" class="pull-left" />
                                    @endfor
                                </span>
                            </div>
                        </div>
                    </section>
                    <div class="clearfix"></div>
                </div>
                <div class="text col-xs-12 col-md-12">
                    <div class="row">@lang('studio.middle_text')</div>
                </div>
                <div class="clearfix"></div>
                <h2 class="text-center sh uppercase" id="equipment">@lang('studio.equipment')</h2>
                <div class="col-xs-12">
                    <div class="col-md-3 col-md-offset-2 col-sm-4 grey-text hrdw">
                        <div class="row">
                            <div class="bordered uppercase">@lang('studio.equip_main')</div>
                            @lang('studio.main_studio')
                        </div>
                    </div>

                    <div class="col-md-3 col-md-offset-3 col-sm-4 col-sm-offset-4 grey-text hrdw">
                        <div class="row">
                            <div class="bordered uppercase">@lang('studio.equip_dj')</div>
                            @lang('studio.dj_studio')
                        </div>
                    </div>
                    <div class="clearfix"></div>


                    <h2 class="text-center sh uppercase" id="services">@lang('studio.services')</h2>
                    <div class="service-images ">
                        @for($i = 1; $i <= 8; $i++)
                            <div class="col-md-3 col-sm-4 text-center scale{{ $i }}">
                                <a href="mailto:info@cts-label.com?body=My name:%0AMy phone number:%0A&Subject=Услуги CTStudio @if(!empty($subject[$i])) - {{ $subject[$i] }} @endif">
                                    <img src="/assets/img/sen{{ $i }}.jpg"
                                        class="service-image" @if(!empty($services[2*$i])) alt="{{ $services[2*$i] }}" @endif>
                                </a>
                            </div>
                        @endfor
                        <div class="clearfix"></div>
                    </div>
                    <ul class="list-inline slist slist-en">
                        <li>@lang('studio.service_1');</li>
                        <li>@lang('studio.service_2');</li>
                        <li>@lang('studio.service_3').</li>
                    </ul>
                    <a class="text-center download" href="http://www.studio.cts.ua/CTS_studio_price_list.PDF"
                       target="_blank">@lang('studio.dl_price')</a>

                    <h2 class="sh text-center uppercase" id="projects">@lang('studio.projects')</h2>
                    <div class="text">@lang('studio.bottom_text')</div>
                    <h2 class="text-center sh uppercase" id="contacts">@lang('studio.contacts')</h2>
                    <div class="text-center col-xs-12">
                        <div style="font-size: 15px; max-width: 200px; display: inline-block;">
                            @lang('studio.contacts_text')
                            <a href="mailto:info@cts-label.com" class="wl"
                                          style="text-transform: lowercase">info@cts-label.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection