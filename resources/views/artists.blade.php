@extends('layout.layout')

@section('title', 'CTS Studio Artists')

@section('content')
    <div class="container pt-3 artists">
        <div class="row">
            <section class="col pe-md-5">
                <h5 class="a-b mt-3 mb-4">@lang('artists.artists_remixers')</h5>
                <div class="row g-0 mb-3">
                    @foreach($artists as $artist)
                        <div class="artist-brief col-6 col-sm-4 col-md-4 col-lg-3 g-0">
                            @if($artist->link) <a href="{{ $artist->link }}" target="_blank">@endif
                                <img src="/images/artists/{{ $artist->image }}" alt="{{ $artist->name }}" class="img-fluid">
                                <div class="artist-title">{{ $artist->name }}</div>
                            @if($artist->link)</a>@endif
                        </div>
                    @endforeach
                </div>
                {{ $artists->links('layout.pagination') }}
            </section>
            @include('layout.aside')
        </div>
    </div>
@endsection
