@extends('layout.layout')

@section('title', $release->title)

@section('description', htmlspecialchars_decode(str_replace('&nbsp;', ' ', strip_tags($release['description_'.$release->detectActiveDescriptionLang()]))))

@section('meta')
    <meta property="og:title" content="{{ $release->title }}">
    <meta property="og:description" content="{!! htmlspecialchars_decode(str_replace('&nbsp;', ' ', strip_tags($release['description_'.$release->detectActiveDescriptionLang()]))) !!}">
    <meta property="og:image" content="{{ url('/') }}/images/releases/{{ $release->image }}">
    <meta property="og:url" content="{{ route('release', $release->id) }}">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="CTS Records">
@endsection

@section('content')

    <div class="container release pt-3">
        <div class="row">
            <section class="col pe-md-5">
                <div class="row">
                    <div class="col-xs-12 col-sm-7">
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
                    <div class="col-xs-12 col-sm-7">
                        <figure>
                            <img src="/images/releases/{{ $release->image }}" alt="{{ $release->title }}" class="release-image img-fluid w-100"/>
                        </figure>
                        <div class="release-buttons d-flex justify-content-between py-md-5 py-3">
                            <a @if($release->youtube) href="{{ $release->youtube }}" @endif target="_blank" rel="noreferrer"
                               @class(['share', 'btn-disabled' => !$release->youtube])>
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                            <a @if($release->beatport) href="{{ $release->beatport }}" @endif target="_blank" rel="noreferrer"
                                @class(['share', 'btn-disabled' => !$release->beatport])>
                                <i @class([
                                        'icon-beatport' => $release->getStore() === 'beatport' || $release->getStore() === null,
                                        'icon-discogs' => $release->getStore() === 'discogs',
                                        'fa-brands fa-spotify' => $release->getStore() === 'spotify',
                                        'fa-solid fa-download' => $release->getStore() === 'cts',
                                    ])></i>
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
                        <div class="release-tracklist mb-md-0 mb-3">
                            @if($release->tracks)
                                <h6 class="fw-bold">@lang('releases.tracklist')</h6>
                                @if($release->tracklist_show_custom)
                                    {!! $release->tracklist !!}
                                @else
                                    @foreach($release->tracks as $track)
                                        <p class="mb-0">
                                            {{ $release->getTracklistRow($track) }}
                                            @if($track->youtube)
                                                <a href="{{ $track->youtube }}" target="_blank" rel="noreferrer" class="text-muted"><i class="fa-brands fa-youtube"></i></a>
                                            @endif
                                        </p>
                                    @endforeach
                                @endif

                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5 release-content">
                        {!! $release['description_'.$release->detectActiveDescriptionLang()] !!}
                    </div>
                </div>
                @if(count($release->related) > 0)
                    <div class="row py-5">
                        <div class="col-12 release-related">
                            <h6 class="mb-3">@lang('releases.related_releases')</h6>
                            <div class="row g-0">
                                @foreach($release->related as $item)
                                    <div class="col-4 g-2">
                                        <div class="release-brief release-brief-related">
                                            <a href="{{ route('release', $item->id) }}" class="d-block">
                                                <img src="/images/releases/{{ $item->image }}" alt="{{ $item->title }}" class="img-fluid">
                                                <div class="item-overlay d-flex justify-content-center align-items-center p-3 text-center">
                                                    <span class="">{{ $item->title }}</span>
                                                </div>
                                            </a>
                                        </div>
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

@section('json-ld')

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MusicAlbum",
        "name": "{{ $release->title }}",
        "image": "{{ url('/') }}/images/releases/{{ $release->image }}",
        "url": "{{ route('release', $release->id) }}",
        "albumProductionType": "https://schema.org/StudioAlbum",
        @if($release->tracks)
            "track": {
                "@type": "ItemList",
                "numberOfItems": {{ count($release->tracks) }},
                "itemListElement": [
                    @foreach($release->tracks as $track)
                        {
                            "@type": "ListItem",
                            "position": {{ $loop->iteration }},
                                    "item": {
                                        "@type": "MusicRecording",
                                        "isrcCode": "{{ $track->isrc }}",
                                        "byArtist": {
                                            "@type": "MusicGroup",
                                            "name": "{{ $track->artists }}"
                                        },
                                        @if($track->length)
                            "duration": "{{ $track->lengthToIso8601() }}",
                                        @endif
                        "name": "{{ $track->name }}@if($track->mix_name) ({{ $track->mix_name }})@endif"
                        }
                    }@if(!$loop->last),@endif
                @endforeach
                ]
            }
        @endif
    }
</script>

@endsection
