@extends('layout.layout')

@section('title', $release->title)
@section('scripts')
    <script type="text/javascript" src="{{ mix('js/release_player.js') }}"></script>
@endsection

@section('meta')
    <link rel="canonical" href="https://cts-label.com/releases/{{ $release->id }}">
    @if($release['description_'.$release->detectActiveDescriptionLang()])
        <meta name="description" content="{!! htmlspecialchars_decode(str_replace('&nbsp;', ' ', strip_tags($release['description_'.$release->detectActiveDescriptionLang()]))) !!}">
    @endif

    <!-- OG Meta tags -->
    <meta property="og:locale" content="uk_UA">
    <meta property="og:type" content="music.album">
    <meta property="og:title" content="{{ $release->title }}">
    @if($release['description_'.$release->detectActiveDescriptionLang()])
        <meta property="og:description" content="{!! htmlspecialchars_decode(str_replace('&nbsp;', ' ', strip_tags($release['description_'.$release->detectActiveDescriptionLang()]))) !!}">
    @endif
    @if($release->image)
        <meta property="og:image" content="{{ url('/') }}/images/releases/{{ $release->image }}">
    @endif
    <meta property="og:url" content="{{ route('release', $release->id) }}">
    <meta property="og:site_name" content="CTS Records">
    @if($release->release_date)
        <meta property="music:release_date" content="{{ $release->release_date->format('Y-m-d') }}">
    @endif

    <!-- Twitter Meta tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $release->title }}">
    @if($release['description_'.$release->detectActiveDescriptionLang()])
        <meta name="twitter:description" content="{!! htmlspecialchars_decode(str_replace('&nbsp;', ' ', strip_tags($release['description_'.$release->detectActiveDescriptionLang()]))) !!}">
    @endif
    @if($release->image)
        <meta name="twitter:image" content="{{ url('/') }}/images/releases/{{ $release->image }}">
        <meta name="twitter:image:alt" content="{{ $release->title }}">
    @endif
    <meta name="twitter:site" content="@CTS_RECORDS">
    @if($release->release_date)
        <meta name="twitter:label1" content="Release Date">
        <meta name="twitter:data1" content="{{ $release->release_date->isoFormat('LL') }}">
    @endif
    @if($release->genre)
        <meta name="twitter:label2" content="Genre">
        <meta name="twitter:data2" content="{{ $release->genre }}">
    @endif

@endsection

@section('content')

    <div class="container release pt-3">
        <div class="row flex-md-nowrap">
            <section class="col pe-md-5">
                <div class="row">
                    <div class="col-xs-12 col-sm-7">
                        <h1 class="release-title">{{ $release->title }}</h1>
                        @if($release->release_number)
                            <h2 class="release-number"><strong>@lang('releases.release_number') </strong>{{ $release->release_number }}</h2>
                        @endif
                        @if($release->release_date)
                            <h2 class="release-date"><strong>@lang('releases.release_date') </strong>{{ $release->release_date->format('j F Y') }}</h2>
                        @endif
                    </div>
                    <div class="col-xs-12 col-md-5">
                        <div class="text-center">
                            <a @if($prev)href="{{ route('release', $prev->id) }}" @endif class="prev-btn search-btns @if(!$prev)btn-disabled @endif" title="Previous">&nbsp;</a>
                            <span class="release-search">@lang('releases.search_release')</span>
                            <a @if($next)href="{{ route('release', $next->id) }}" @endif class="next-btn search-btns @if(!$next)btn-disabled @endif" title="Next">&nbsp;</a>
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
                <div class="row release-info-wrapper">
                    <div class="col-xs-12 col-sm-7">
                        <figure>
                            <x-picture :src="['/images/releases/'.($release->image ?? $release->image_270)]" alt="{{ $release->title }}" class="release-image img-fluid w-100"/>
                        </figure>
                        <div class="release-buttons d-flex justify-content-between py-md-5 py-3">
                            <a @if($release->youtube) href="{{ $release->youtube }}" @endif target="_blank" rel="noreferrer"
                               data-bs-toggle="tooltip" data-bs-title="@lang('releases.watch')"
                               @class(['share', 'btn-disabled' => !$release->youtube])>
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                            <a @if($release->beatport) href="{{ $release->beatport }}" @endif target="_blank" rel="noreferrer"
                               data-bs-toggle="tooltip" data-bs-title="@lang('releases.buy')"
                                @class(['share', 'btn-disabled' => !$release->beatport])>
                                <i @class([
                                        'icon-beatport' => $release->getStore() === 'beatport' || $release->getStore() === null,
                                        'icon-discogs' => $release->getStore() === 'discogs',
                                        'fa-brands fa-spotify' => $release->getStore() === 'spotify',
                                        'fa-solid fa-download' => $release->getStore() === 'cts',
                                    ])></i>
                            </a>
                            <button type="button" class="share sharer share-facebook" data-social="fb"
                                    data-bs-toggle="tooltip" data-bs-title="@lang('releases.share_facebook')">
                                <i class="fa-brands fa-facebook-f"></i>
                            </button>
                            <button type="button" class="share sharer share-twitter" data-social="tw"
                                    data-bs-toggle="tooltip" data-bs-title="@lang('releases.share_x')">
                                <i class="fa-brands fa-x-twitter"></i>
                            </button>
                            <button type="button" class="share sharer share-mail" data-social="mail"
                                    data-bs-toggle="tooltip" data-bs-title="@lang('releases.share_email')">
                                <i class="fa-solid fa-envelope"></i>
                            </button>
                        </div>
                        <div class="release-tracklist mb-md-0 mb-3">
                            @if(count($release->tracks) > 0)
                                <h2 class="fw-bold">@lang('releases.tracklist')</h2>
                                @if($release->tracklist_show_custom)
                                    {!! $release->tracklist !!}
                                @else
                                    <table>
                                        <tbody>
                                        @foreach($release->tracks as $track)
                                            <tr>
                                                <td class="pb-1">
                                                    @if($track->beatport_sample && $track->beatport_wave && $track->beatport_sample_start && $track->beatport_sample_end && $track->length)
                                                        <button type="button" class="btn btn-sm btn-flat text-muted" data-track-id="{{ $track->id }}" data-release-id="{{ $release->id }}"><i class="fa-solid fa-play"></i></button>
                                                    @endif
                                                </td>
                                                <td class="pb-1">
                                                    {{ $release->getTracklistRow($track) }}
                                                    @if($track->youtube)
                                                        <a href="{{ $track->youtube }}" target="_blank" rel="noreferrer" class="text-muted"><i class="fa-brands fa-youtube"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5 release-content">
                        <div class="release-content-wrapper">
                            {!! $release['description_'.$release->detectActiveDescriptionLang()] !!}
                        </div>
                    </div>
                </div>
                @if(count($release->related) > 0)
                    <div class="row py-5">
                        <div class="col-12 release-related">
                            <h2 class="fw-bold">@lang('releases.related_releases')</h2>
                            <div class="row g-0">
                                @foreach($release->related as $item)
                                    <div class="col-4 g-2">
                                        <div class="release-brief release-brief-related">
                                            <a href="{{ route('release', $item->id) }}" class="d-block" title="{{ $item->title }}">
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
        @if($release->image)"image": "{{ url('/') }}/images/releases/{{ $release->image }}", @endif
        "url": "{{ route('release', $release->id) }}",
        "albumProductionType": "https://schema.org/StudioAlbum",
        @if(count($release->tracks) > 0)
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
