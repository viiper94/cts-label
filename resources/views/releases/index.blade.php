@extends('layout.layout')

@section('title', 'CTS Records - New Electronic Music')

@section('keywords', 'CTS, Creative Technologies Studio, electronic music')
@section('description', 'CTS - Creative Technologies Studio - one of the first independent record labels based in Ukraine working in electronic dance music sphere.')

@section('content')
    <div class="container pt-3">
        <div class="row">
            <section class="col-md">
                <div class="row g-1">
                    @foreach($releases as $release)
                        <div class="col-6 col-sm-4 mb-4 g-2">
                            <div class="release-brief">
                                <a href="{{ route('release', $release->id) }}" class="d-block">
                                    <x-picture :src="['/images/releases/'.($release->image_270 ?? $release->image)]"
                                               alt="{{ $release->title }}" class="img-fluid" loading="lazy"/>
                                    <div class="item-overlay d-flex justify-content-center align-items-center p-3 text-center">
                                        <span class="">{{ $release->title }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $releases->links('layout.pagination') }}
            </section>
            @include('layout.aside')
        </div>
    </div>
@endsection

@section('meta')
    <link rel="canonical" href="https://cts-label.com">
    <!-- OG Meta tags -->
    <meta property="og:title" content="CTS Records">
    <meta property="og:type" content="music.record_label">
    <meta property="og:url" content="https://cts-label.com/">
    <meta property="og:image" content="https://cts-label.com/images/logo.png">
    <meta property="og:description" content="CTS - Creative Technologies Studio - one of the first independent record labels based in Ukraine working in electronic dance music sphere.">

    <!-- Twitter Meta tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@CTS_RECORDS">
    <meta name="twitter:title" content="CTS Records">
    <meta name="twitter:description" content="CTS - Creative Technologies Studio - one of the first independent record labels based in Ukraine working in electronic dance music sphere.">
    <meta name="twitter:image" content="https://cts-label.com/images/logo.png">

@endsection

@section('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "MusicGroup",
  "name": "CTS Records",
  "url": "https://cts-label.com/",
  "sameAs": [
    "https://facebook.com/CTS.Records",
    "https://twitter.com/CTS_RECORDS",
    "https://www.youtube.com/channel/UCudx-EMGd8zRddRAFWl7YHA"
  ],
  "logo": "https://cts-label.com/images/logo.png",
  "image": "https://cts-label.com/images/logo.png",
  "musicGenre": "House, Techno, Tech House, Indie Dance",
  "description": "CTS - Creative Technologies Studio - one of the first independent record labels based in Ukraine working in electronic dance music sphere.",
  "album": [
@foreach($releases->take(3) as $release)
        {
        "@type": "MusicAlbum",
        "name": "{{ $release->title }}",
        "image": "{{ url('/') }}/images/releases/{{ $release->image }}",
        @if($release->genre) "genre": "{{ $release->genre }}",
        @endif
        "releaseDate": "{{ $release->release_date->format('Y-m-d') }}",
        "recordLabel": "CTS Records"
      }@if(!$loop->last), @endif

@endforeach
  ]
}
</script>
@endsection
