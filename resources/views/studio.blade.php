@extends('layout.layout')

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

    <div class="studio">
        <div class="studio-header py-5">
            <div class="container py-3">
                <div class="lang-switch">
                    <div class="btn-group">
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en'])
                           data-lang="en" href="{{ route('studio') }}">
                            @lang('shared.en')
                        </a>
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ua' || !isset($_COOKIE['lang'])])
                           data-lang="ua" href="{{ route('studio') }}">
                            @lang('shared.ua')
                        </a>
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ru'])
                           data-lang="ru" href="{{ route('studio') }}">
                            @lang('shared.ru')
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="studio-nav">
            <div class="container">
                <ul class="py-3 px-0">
                    <li><a href="#equipment">@lang('studio.equipment')</a></li>
                    <li><a href="#services">@lang('studio.services')</a></li>
                    <li><a href="#projects">@lang('studio.projects')</a></li>
                    <li><a href="#contacts">@lang('studio.contacts')</a></li>
                </ul>
            </div>
        </div>
        <div class="studio-content">
            <div class="container">
                <section class="description">
                    <div class="text pt-5">
                        @lang('studio.top_text')
                    </div>
                    <div class="marquee overflow-hidden mb-3">
                        <div class="marquee-flow d-flex">
                        <span class="d-flex">
                            @for($i = 1; $i <= 8; $i++)
                                <img src="/images/studio-{{ $i }}.jpg">
                            @endfor
                        </span>
                            <span class="d-flex">
                            @for($i = 1; $i <= 8; $i++)
                                    <img src="/images/studio-{{ $i }}.jpg">
                                @endfor
                        </span>
                        </div>
                    </div>
                    <div class="text">
                        @lang('studio.middle_text')
                    </div>
                </section>
                <section class="equipment py-5">
                    <h1 class="text-center text-uppercase fw-bold mb-5" id="equipment">@lang('studio.equipment')</h1>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <p class="equipment-header text-uppercase py-2 m-auto">
                                @lang('studio.equip_main')
                            </p>
                            <div class="equipment-text pt-5">
                                @lang('studio.main_studio')
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <p class="equipment-header text-uppercase py-2 m-auto">
                                @lang('studio.equip_dj')
                            </p>
                            <div class="equipment-text pt-5">
                                @lang('studio.dj_studio')
                            </div>
                        </div>
                    </div>
                </section>
                <section class="services py-5">
                    <h1 class="text-center text-uppercase fw-bold mb-5" id="services">@lang('studio.services')</h1>
                    <div class="service-images d-flex justify-content-between px-5 flex-wrap">
                        @foreach($services as $service)
                            <div class="service-item m-3">
                                <a data-bs-toggle="modal" data-bs-target="#service-modal" data-name="{{ $service->name }}" class="service-link">
                                    <img src="/images/studio/services/{{ $service->image }}"
                                         class="service-image" @if($service->alt) alt="{{ $service->alt }}" @endif>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <ul class="px-5 py-3 mb-0">
                        <li>@lang('studio.service_1');</li>
                        <li>@lang('studio.service_2');</li>
                        <li>@lang('studio.service_3').</li>
                    </ul>
                    <div class="d-flex justify-content-center">
                        <a class="text-center text-uppercase price-list" href="/CTS_studio_price_list.PDF" target="_blank">@lang('studio.dl_price')</a>
                    </div>
                </section>
                <section class="projects py-5">
                    <h1 class="text-center text-uppercase fw-bold mb-5" id="projects">@lang('studio.projects')</h1>
                    <div class="text">@lang('studio.bottom_text')</div>
                </section>
                <section class="contacts pt-5">
                    <h1 class="text-center text-uppercase fw-bold mb-5" id="contacts">@lang('studio.contacts')</h1>
                    <div class="text-center">
                        @lang('studio.contacts_text')
                        <a href="mailto:info@cts-label.com">info@cts-label.com</a>
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
                        <h1 class="modal-title fs-5" id="modalLabel">@lang('studio.modal.header')</h1>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="service" class="form-label">@lang('studio.modal.service')</label>
                            <input type="text" name="service" id="service" class="form-control form-dark" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">@lang('studio.modal.your_name')*</label>
                            <input type="text" name="name" id="name" class="form-control form-dark" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tel" class="form-label">@lang('studio.modal.your_tel')</label>
                            <input type="tel" name="tel" id="tel" class="form-control form-dark">
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">@lang('studio.modal.your_email')*</label>
                            <input type="email" name="email" id="email" class="form-control form-dark" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('studio.modal.submit')</button>
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
