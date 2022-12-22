@extends('layout.layout')

@section('title', $release->title)

@section('content')
    <div class="container release pt-3">
        <div class="row">
            <section class="col pe-5">
                <div class="row">
                    <div class="col-xs-12 col-md-7">
                        <h1 class="release-title">{{ $release->title }}</h1>
                        <div class="release-number"><strong>@lang('releases.release_number') </strong>{{ $release->release_number }}</div>
                        <div class="release-date"><strong>@lang('releases.release_date') </strong>{{ $release->release_date->format('j F Y') }}</div>
                    </div>
                    <div class="col-xs-12 col-md-5">
                        <div class="text-center">
                            <a @if($prev)href="{{ route('release', $prev->id) }}" @endif class="prev-btn search-btns @if(!$prev)btn-disabled @endif">&nbsp;</a>
                            <span class="release-search">@lang('releases.search_release')</span>
                            <a @if($next)href="{{ route('release', $next->id) }}" @endif class="next-btn search-btns @if(!$next)btn-disabled @endif">&nbsp;</a>
                        </div>
                        <div class="lang-switch pb-3">
                            @if($release->detectActiveDescriptionLang(count: true) > 1)
                                <div class="btn-group">
                                    @foreach(['en', 'ua', 'ru'] as $item)
                                        @if($release->getUsefulText($release['description_'.$item]))
                                            <a @class(['btn switch-btn', 'active' => $release->detectActiveDescriptionLang() === $item])
                                               data-lang="{{ $item }}" href="{{ route('release', $release->id) }}">@lang('shared.'.$item)</a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-7">
                        <figure>
                            <img src="/images/releases/{{ $release->image }}" alt="{{ $release->title }}" class="release-image img-fluid w-100"/>
                        </figure>
                        <div class="release-buttons d-flex justify-content-between py-5">
                            <a @if($release->youtube) href="{{ $release->youtube }}" @endif target="_blank"
                               @class(['share', 'btn-disabled' => !$release->youtube])>
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                            <a @if($release->beatport) href="{{ $release->beatport }}" @endif target="_blank"
                                @class(['share', 'btn-disabled' => !$release->beatport])>
                                <i class="icon-beatport"></i>
                            </a>
                            <button type="button" class="share sharer share-facebook" data-social="fb">
                                <i class="fa-brands fa-facebook-f"></i>
                            </button>
                            <button type="button" class="share sharer share-twitter" data-social="tw">
                                <i class="fa-brands fa-twitter"></i>
                            </button>
                            <button type="button" class="share sharer share-mail" data-social="mail">
                                <i class="fa-solid fa-envelope"></i>
                            </button>
                        </div>
                        <div class="release-tracklist">
                            @if($release->tracklist)
                                <h6 class="fw-bold">@lang('releases.tracklist')</h6>
                                {!! $release->tracklist !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-5 release-content">
                        {!! $release['description_'.$release->detectActiveDescriptionLang()] !!}
                    </div>
                </div>
                @if($release->related)
                    <div class="row py-5">
                        <div class="col-12 release-related">
                            <h6 class="mb-3">@lang('releases.related_releases')</h6>
                            <div class="d-flex justify-content-between flex-wrap">
                                @foreach($release->related as $item)
                                    <div class="release-brief release-brief-related">
                                        <a href="{{ route('release', $item->id) }}" class="d-block">
                                            <img src="/images/releases/{{ $item->image }}" alt="{{ $item->title }}" class="img-fluid">
                                            <div class="item-overlay d-flex justify-content-center align-items-center p-3 text-center">
                                                <span class="">{{ $item->title }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </section>
            @include('layout.aside')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/assets/js/readmore.js"></script>
    <script>
        $('.inner-tracklist').readmore({
            collapsedHeight: 276,
            embedCSS: false
        });

        $('.content-en, .content-ru, .content-ua').readmore({
            collapsedHeight: 849,
            embedCSS: false
        });
    </script>
@endsection
