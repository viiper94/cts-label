@extends('layout.layout')

@section('title', $release->title)

@section('content')
    <div class = "container">
        <div class="col-md-9 col-sm-8 content" >
            <div class="row" style="padding:0 17px;">
                <div class="col-xs-12 col-md-7" >
                    <h1 class="release-title">{{ $release->title }}</h1>
                    <div class="release-number"><strong>@lang('releases.release_number') </strong>{{ $release->release_number }}</div>
                    <div class="release-date"><strong>@lang('releases.release_date') </strong>{{ date('j F Y', $release->release_date->getTimestamp()) }}</div>
                </div>
                <div class="col-xs-12 col-md-5" >
                    <div class="text-center">
                        <a @if($prev) href="{{ route('release', $prev->id) }}" @endif class="prev-btn search-btns @if(!$prev)btn-disabled @endif">&nbsp;</a>
                        <span class="release-search">@lang('releases.search_release')</span>
                        <a @if($next)href="{{ route('release', $next->id) }}" @endif class="next-btn search-btns @if(!$next)btn-disabled @endif">&nbsp;</a>
                    </div>
                    <div class="text-right switch-btns">
                        @if($release->detectActiveDescriptionLang(true) > 1)
                            @if($release->getUsefulText($release->description_en))
                                <a class="switch-btn pull-right @if($release->detectActiveDescriptionLang() === 'en') active @endif"
                                    data-lang="en" href="{{!$_SERVER['QUERY_STRING'] ? '' : '?'.$_SERVER['QUERY_STRING']}}">@lang('shared.en')</a>
                            @endif
                            @if($release->getUsefulText($release->description_ru))
                                <a class="switch-btn pull-right @if($release->detectActiveDescriptionLang() === 'ru') active @endif"
                                   data-lang="ru" href="{{!$_SERVER['QUERY_STRING'] ? '' : '?'.$_SERVER['QUERY_STRING']}}">@lang('shared.ru')</a>
                            @endif
                            @if($release->getUsefulText($release->description_ua))
                                <a class="switch-btn pull-right @if($release->detectActiveDescriptionLang() === 'ua') active @endif"
                                   data-lang="ua" href="{{!$_SERVER['QUERY_STRING'] ? '' : '?'.$_SERVER['QUERY_STRING']}}">@lang('shared.ua')</a>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-md-7">
                    <figure>
                        <img src="/images/releases/{{ $release->image }}" alt="{{ $release->title }}" class="release-image img-responsive"/>
                    </figure>
                    <div class="release-buttons">
                        <a @if($release->youtube) href="{{ $release->youtube }}" @endif target="_blank" class="share share-play @if(!$release->youtube) btn-disabled @endif"></a>
                        <a @if($release->beatport) href="{{ $release->beatport }}" @endif target="_blank" class="share share-beatport @if(!$release->beatport) btn-disabled @endif"></a>
                        <a href="javascript:void(0)" onclick="shareSocial('fb')" class="share share-facebook"></a>
                        <a href="javascript:void(0)" onclick="shareSocial('twitter')" class="share share-twitter"></a>
                        <div id="share-share" class="share share-share" style="position: relative;" data-toggle="collapse" data-target="#collapsed-social">
                            <div id="collapsed-social" class="collapse">
                                <a href="javascript:void(0)" onclick="shareSocial('vk')" class="collapsed-share share-vk"></a>
                                <a href="javascript:void(0)" onclick="shareSocial('google')" class="collapsed-share share-google-plus"></a>
                                <a href="javascript:void(0)" onclick="shareSocial('lj')" class="collapsed-share share-lj"></a>
                                <a href="javascript:void(0)" onclick="shareSocial('pin')" class="collapsed-share share-pin"></a>
                                <a href="javascript:void(0)" onclick="shareSocial('mail')" class="collapsed-share share-mail"></a>
                            </div>
                        </div>
                    </div>
                    <div class="release-tracklist">
                        <div class="inner-tracklist">
                            @if($release->tracklist)
                            <b>@lang('releases.tracklist')</b><br/>
                            {!! $release->tracklist !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="release-content col-xs-12 col-md-5">
                    <div class="content-ru">
                        {!! $release['description_'.$release->detectActiveDescriptionLang()] !!}
                    </div>
                </div>
                <div class="clearfix"></div>
                @if(count($release->related) > 0)
                    <div class="col-xs-12 release-related">
                        <span>@lang('releases.related_releases')</span>
                        @foreach($release->related as $item)
                            <div class="col-md-4 col-sm-6 col-xs-6 release-brief release-brief-related">
                                <a href="{{ route('release', $item->id) }}">
                                    <img src="/images/releases/{{ $item->image }}" alt="{{ $item->title }}" class="img-responsive"/>
                                    <div class="item-overlay">
                                        <div class="item-data">
                                            <div>{{ $item->title }}</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
        @include('layout.aside')
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
