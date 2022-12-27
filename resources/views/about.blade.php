@extends('layout.layout')

@section('title', 'About CTS')

@section('content')

    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "CTS Label",
          "url" : "https://www.cts-label.com",
          "logo": "https://www.cts-label.com/images/logo.png",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Kyiv, Ukraine",
            "streetAddress": "Бессарабська площа, 4,"
          },
          "email": "info(at)cts-label.com",

         "telephone": "+38 098 685 40 33"
        }
    </script>

    <div class="container about pt-3">
        <div class="row">
            <section class="col pe-5" data-bs-spy="scroll" data-bs-target="#main_nav" data-bs-rootMargin="-30px 0 -88% 0px" data-bs-threshold=".7">
                <div id="about">
                    <h5 class="a-b mt-3 mb-4">@lang('navbar.about')</h5>
                    @lang('about.about')
                </div>
                <div class="pb-5">
                    <p>
                        <a data-target="#collapsable" data-bs-toggle="collapse" aria-expanded="false" href="#subscribe" aria-controls="subscribe">
                            @lang('about.subscribe')
                        </a>
                    </p>
                    <form id="subscribe" method="POST" name="subscribe-email" class="collapse">
                        <div class="form-group row">
                            <div class="col">
                                <input name="name" required type="text" class="form-control form-control-sm form-dark" placeholder="@lang('about.subscribe_name')">
                            </div>
                            <div class="col">
                                <input name="email" required type="email" class="form-control form-control-sm form-dark" placeholder="@lang('about.subscribe_email')">
                            </div>
                            <div class="col">
                                <input type="submit" value="@lang('about.subscribe_submit')" class="btn btn-outline btn-sm">
                            </div>
                        </div>
                    </form>
                </div>
                <div id="demo" class="py-5 mb-5">
                    <h5 class="a-b mt-3 mb-4">@lang('about.demo_policy')</h5>
                    @lang('about.demo')
                </div>
                <div id="contacts" class="">
                    <h5 class="a-b mt-3 mb-4">@lang('navbar.contact')</h5>
                    <div class="pt-2 pb-5 cts-records">
                        <h6>@lang('about.contact_cts_studio_requests')</h6>
                        <p>@lang('about.contact_general_info') <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
                        <p>@lang('about.contact_bookings') <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
                        <p>@lang('about.contact_a_and_r') <a href="mailto:info@sergiomega.com">info@sergiomega.com</a></p>
                        <p>@lang('about.contact_licencing') <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
                    </div>
                    <div class="pt-3 pb-5 cts-school">
                        <h6>@lang('about.contact_cts_school_requests')</h6>
                        <p>@lang('about.contact_email') <a href="mailto:info@cts-studio.com">info@cts-label.com</a></p>
                        <p>@lang('about.contact_t') <a href="tel:+380986854033">+380 98 685 40 33</a></p>
                    </div>
                    <div class="pt-3 pb-5 cts-studio">
                        <h6>CTS Studio requests:</h6>
                        <p>@lang('about.contact_email') <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
                        <p>@lang('about.contact_t') <a href="tel:+380986854033">+380 98 685 40 33</a></p>
                    </div>
                </div>
            </section>
            @include('layout.aside')
        </div>
    </div>
@endsection
