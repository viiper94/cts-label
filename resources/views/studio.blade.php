@extends('layout.layout')

@section('assets')
    <link href="/assets/css/ctssc2.css" rel="stylesheet" />
    <link  href="/assets/css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="/assets/js/modernizr.js"></script>
@endsection

@section('title')
    @lang('studio.page_header')
@endsection

@section('keywords')
    CTS, Studio, студия, ремиксы, мастеринг, аранжировка, вокал, сведение, школа, диджеинг, продюсеринг, запись,
    услуги звукозаписи, CTS, CTS studio Kiev, CTS studio Kyiv, studio CTS, CTS студия, CTS студія, услуги студии
    звукозаписи Киев, студия звукозаписи Киев, профессиональная студия в Киеве, профессиональная студия Киев, послуги
    студії звукозапису Київ, студія звукозапису Київ, професіональна студія в Києві, професіональна студія Київ, pdtltyyz,
    зведення, зведення музикальних композицій, зведення та мастеринг, зведення та мастеринг електронної музики,
    мастеринг, мастеринг Київ, якісне зведення Київ, зведення музикальних композицій у Києві, cstltybt, сведение,
    vdcnthbyu, мастеринг, сведение и мастеринг, сведение и мастеринг єлектронной музыки, профессиональное сведение,
    профессиональный мастеринг, качественное сведение и мастеринг в Киеве, mixing, mastering, mixing and mastering,
    professional mixing and mastering, quality mixing and mastering in Kiev
@endsection

@section('description')
    CTS Studio - студія звукозапису незалежного рекорд-лейблу CTS Records
@endsection

@section('meta')
    <meta property="og:title" content="CTS Studio - професійна студія звукозапису незалежного рекорд-лейблу CTS Records в Києві">
    <meta property="og:description" content="CTS Studio - професійна студія звукозапису незалежного рекорд-лейблу CTS Records в Києві">
    <meta property="og:image" content="https://www.cts-label.com/assets/img/cts-studio-y.png">
    <meta property="og:url" content="https://cts-label.com/studio.html">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="CTStudio">
@endsection

@section('content')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Cтудія звукозапису CTS Records",
      "url" : "https://www.cts-label.com/studio.html",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Kyiv, Ukraine",
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
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="school-menu studio-land">
                    <div class="container">
                        <ul class="list-unstyled s-menu studio-menu">
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
                        @foreach($services as $service)
                            <div class="col-md-3 col-sm-4 text-center scale{{ $loop->iteration }}">
                                <a href="mailto:info@cts-label.com?body=@lang('mail.my_name')%0A @lang('mail.my_phone')%0A&Subject=@lang('studio.services') - {{ $service->name }}">
                                    <img src="/images/studio/services/{{ $service->image }}"
                                         class="service-image" @if($service->alt) alt="{{ $service->alt }}" @endif>
                                </a>
                            </div>
                        @endforeach
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
