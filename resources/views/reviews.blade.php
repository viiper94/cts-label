@extends('layout.layout')

@section('title', 'Reviews')

@section('description', 'CTS - Creative Technologies Studio - one of the first independent record labels based in Ukraine working in electronic dance music sphere.')

@section('meta')
    <link rel="canonical" @if(Request::input('page'))href="https://cts-label.com/reviews?page={{ Request::input('page') }}" @else href="https://cts-label.com/reviews" @endif>
@endsection

@section('content')
    <div class="container reviews pt-3">
        <div class="row">
            <section class="col">
                <h5 class="a-b mt-3 mb-4">@lang('reviews.reviews')</h5>
                @foreach($tracks as $track)
                    <div class="review-brief me-5 pb-5 mb-5">
                        <h6 class="review-track fw-bold mb-4">{{ $track->getFullTitle() }}</h6>
                        @if(count($track->reviews) > 0)
                            @foreach($track->reviews as $review)
                                <div class="review my-3">
                                    <p class="fw-bold mb-0"><i class="fa-solid fa-angles-right me-1"></i>{{ $review->author }}</p>
                                    @if($review->location)
                                        <p class="location fw-bold mb-0">({{ $review->location }})</p>
                                    @endif
                                    <div class="row pt-2">
                                        <div class="col-12 col-sm-7">
                                            <p class="review-text">{{ $review->review }}</p>
                                        </div>
                                        <div class="col-12 col-sm-5 review-score">
                                            @for($i = 0; $i < $review->score; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @if(count($track->also_supported) > 0)
                            <div class="also-supported">
                                <p class="mb-0">@lang('reviews.also_supported_and_reviewed')</p>
                                @foreach($track->also_supported as $review)
                                    @if($review->author)
                                        <span class="fw-bold text-nowrap"><i class="fa-solid fa-angles-right me-1"></i>{{ $review->author }}</span>
                                        @if($review->location)
                                            <span> ({{ $review->location }})</span>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
                {{ $tracks->links('layout.pagination') }}
            </section>
            @include('layout.aside')
        </div>
    </div>
@endsection
