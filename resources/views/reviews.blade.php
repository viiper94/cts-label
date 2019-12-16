@extends('layout.layout')

@section('title', 'Reviews')

@section('content')
    <div class = "container">
        <div class="col-md-9 col-sm-8 content inner">
            <div class="row" style="padding:0 30px 0 0;">
                <div class="a-b">@lang('reviews.reviews')</div>
                @foreach($tracks as $review)
                    <div class="col-xs-12 review-brief">
                        <div class="row">
                            <h2>{{ $review->track }}</h2>
                            @if(!$review->data) @dd($review->id) @endif
                            @foreach($review->data['reviews'] as $item)
                                @if($item['author'] && $item['review'])
                                    <h3>{{ $item['author'] }}</h3>
                                    @if($item['location'])
                                        <div class="location">({{ $item['location'] }})</div>
                                    @endif
                                    <div class="col-sm-6"><div class="row">{{ $item['review'] }}</div></div>
                                    <div class="col-sm-5 col-sm-offset-1">
                                        @for($i = 0; $i < $item['score']; $i++)
                                            <img src="/assets/img/star.png" width="16" height="13" class="pull-left"/>
                                        @endfor
                                    </div>
                                    <div class="clearfix"></div>
                                @endif
                            @endforeach
                            @if($review->data['additional'])
                                <div class="also-supported">@lang('reviews.also_supported')</div>
                                @foreach($review->data['additional'] as $key => $supported)
                                    @if($supported['author'])
                                        <h4>{{ $supported['author'] }}
                                            @if($supported['location'])
                                                <span class="nobold">({{ $supported['location'] }})</span>
                                            @endif
                                        </h4>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $tracks->links('layout.pagination') }}
        </div>
        @include('layout.aside')
    </div>
@endsection
