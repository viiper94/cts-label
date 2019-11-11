@extends('layout.layout')

@section('content')
    <div class = "container">
        <div class="col-md-9 col-sm-8 content">
            <div class="row" style="padding:0 30px 0 10px; margin-bottom:30px;">
                <div class="a-b">@lang('artists.artists_remixers')</div>
                @foreach($artists as $artist)
                <div class="col-sm-3 col-xs-6 artist-brief">
                    <div class="row">
                        <a href="{{ $artist->link ?? '#' }}" @unless($artist->link) target="_blank" @endif>
                            <img src="/images/{{ str_replace('_s', '_f', $artist->image) }}" alt="{{ $artist->name }}"
                                 class="img-responsive" width="100%" height="100%">
                            <div class="artists-title">{{ $artist->name }}</div>
                        </a>
                    </div>
                </div>
                @endforeach
                <div class="clearfix"></div>
            </div>
            {{ $artists->links('layout.pagination') }}
        </div>
        @include('layout.aside')
    </div>
@endsection