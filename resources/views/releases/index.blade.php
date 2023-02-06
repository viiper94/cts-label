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
  "url": "https://www.famousrecords.com/",
  "sameAs": [
    "https://www.facebook.com/famousrecords",
    "https://www.twitter.com/famousrecords",
    "https://www.instagram.com/famousrecords"
  ],
  "logo": "https://www.famousrecords.com/images/logo.png",
  "image": "https://www.famousrecords.com/images/header.jpg",
  "musicGenre": "Pop, Rock, R&B, Hip-Hop",
  "description": "Famous Records is a leading record label, known for discovering and promoting the best talent in popular music genres.",
  "album": [
    {
      "@type": "MusicAlbum",
      "name": "Summer Hits",
      "byArtist": {
        "@type": "MusicGroup",
        "name": "Various Artists"
      },
      "image": "https://www.famousrecords.com/images/albums/summerhits.jpg",
      "genre": "Pop",
      "releaseDate": "2022-06-01",
      "recordLabel": "Famous Records"
    },
    {
      "@type": "MusicAlbum",
      "name": "Rockin' the Night",
      "byArtist": {
        "@type": "MusicGroup",
        "name": "The Rockers"
      },
      "image": "https://www.famousrecords.com/images/albums/rockinthenight.jpg",
      "genre": "Rock",
      "releaseDate": "2022-07-15",
      "recordLabel": "Famous Records"
    }
  ]
}
</script>
@endsection
