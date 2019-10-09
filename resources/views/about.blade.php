@extends('layout.layout')

@section('content')
    <div class="col-md-9 col-sm-8 content inner">
        <div class="row" style="padding:0 30px 0 0;">
            <script type="application/ld+json">
                {
                  "@context": "http://schema.org",
                  "@type": "Organization",
                  "name": "CTS Label",
                  "url" : "http://www.cts-label.com",
                  "logo": "http://www.cts-label.com/assets/img/logo.png",
                  "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "Kiev, Ukraine",
                    "streetAddress": "Бессарабська площа, 4,"
                  },
                  "email": "info(at)cts-label.com",

                 "telephone": "+38 098 685 40 33"
                }
            </script>
            <div>
                <h1>@lang('navbar.about')</h1>
                @lang('about.about')
            </div>
            <div class="popup">
                <p>
                    <a data-target="#collapsable" data-toggle="collapse" aria-expanded="false" href="#subscribe">
                        @lang('about.subscribe')
                    </a>
                </p>
                <form action="#" id="collapsable" method="POST" name="subscribe-email" class="collapse">
                    <input name="name" required type="text" class="popup-form form-control" placeholder="@lang('about.subscribe_name')">
                    <input name="email" required type="email" class="popup-form form-control" placeholder="@lang('about.subscribe_email')">
                    <input type="submit" value="@lang('about.subscribe_submit')" class="popup-form btn">
                </form>
            </div>
            <div id="demo">
                <h1>@lang('about.demo_policy')</h1>
                @lang('about.demo')
            </div>
            <div id="contacts">
                <h1>@lang('navbar.contact')</h1>
                <div class="cts-records">
                    <div class="grey">@lang('about.contact_cts_studio_requests')</div>
                    <p>@lang('about.contact_general_info') <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
                    <p>@lang('about.contact_bookings') <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
                    <p>@lang('about.contact_a_and_r') <a href="mailto:info@sergiomega.com">info@sergiomega.com</a></p>
                    <p>@lang('about.contact_licencing') <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
                </div>
                <div class="cts-school">
                    <div class="grey">@lang('about.contact_cts_school_requests')</div>
                    <p>@lang('about.contact_email') <a href="mailto:info@cts-studio.com">info@cts-label.com</a></p>
                    <p>@lang('about.contact_t') <a href="tel:+38 098 685 40 33">+38 098 685 40 33</a></p>
                </div>
                <div class="cts-studio">
                    <div class="grey">CTS Studio requests:</div>
                    <p>@lang('about.contact_email') <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
                    <p>@lang('about.contact_t') <a href="tel:+38 098 685 40 33">+38 098 685 40 33</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
