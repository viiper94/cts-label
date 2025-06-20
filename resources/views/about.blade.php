@extends('layout.layout')

@section('title', 'About CTS')

@section('keywords')
    CTS, dance music, record label, electronic music, DJ.
@endsection

@section('meta')
    <link rel="canonical" href="https://cts-label.com//about.html">
    <meta name="description" content="CTS - Creative Technologies Studio - one of the first independent record labels based in Ukraine working in electronic dance music sphere.">
@endsection

@section('content')

    <div class="container about pt-3">
        <div class="row">
            <section class="col pe-5">
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
                        <p>@lang('about.contact_t') <a href="tel:+380986854033">+38 067 466 75 13</a></p>
                    </div>
                    <div class="pt-3 pb-5 cts-studio">
                        <h6>CTS Studio requests:</h6>
                        <p>@lang('about.contact_email') <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
                        <p>@lang('about.contact_t') <a href="tel:+380986854033">+30 067 466 75 13</a></p>
                    </div>
                </div>
            </section>
            @include('layout.aside')
        </div>
    </div>
@endsection

@section('json-ld')
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "CTS Records",
          "url" : "https://cts-label.com",
          "logo": "https://cts-label.com/images/logo.png",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Kyiv",
            "addressCountry": "Ukraine",
            "streetAddress": "Bessarabska Square, 4",
            "postalCode": "01001"
          },
          "sameAs": [
            "https://facebook.com/CTS.Records",
            "https://twitter.com/CTS_RECORDS",
            "https://www.youtube.com/channel/UCudx-EMGd8zRddRAFWl7YHA"
          ],
          "telephone": "+38-067-466-75-13",
          "email": "info@cts-label.com"
        }
    </script>
@endsection
