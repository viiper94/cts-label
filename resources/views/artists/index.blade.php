@extends('layout.layout')

@section('title', 'CTS Records Artists')

@section('meta')
    <meta name="description" content="CTS - Creative Technologies Studio - one of the first independent record labels based in Ukraine working in electronic dance music sphere.">
    <link rel="canonical" @if(Request::input('page'))href="https://cts-label.com/artists?page={{ Request::input('page') }}" @else href="https://cts-label.com/artists" @endif>
@endsection

@section('content')
    <div class="container pt-3 artists">
        <div class="row">
            <section class="col pe-md-5">
                <h5 class="a-b mt-3 mb-4">@lang('artists.artists_remixers')</h5>
                <div class="row g-0 mb-3">
                    @foreach($artists as $artist)
                        <div class="artist-brief col-6 col-sm-4 col-md-4 col-lg-3 g-0">
                            <a href="{{ $artist->getLink() }}" target="_blank">
                                <x-picture :src="[
                                    '/images/artists/'.$artist->image_webp,
                                    '/images/artists/'.$artist->image
                                ]" alt="{{ $artist->name }}" loading="lazy"/>
                                <div class="artist-title">{{ $artist->name }}</div>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{ $artists->links('layout.pagination') }}
            </section>
            @include('layout.aside')
        </div>
    </div>
@endsection
