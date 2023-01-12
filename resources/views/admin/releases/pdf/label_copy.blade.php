<div class="wrapper">

    <img src="{{ public_path('images/label_copy_header.jpg') }}">

    <span class="mb-0">Label copy:</span><br>
    <p class="fs-18 mt-0">{{ $track->artists }} - {{ $track->name }} @if($track->mix_name)({{ $track->mix_name }})@endif</p>

    <div class="info">
        <p>Artist: <b>{{ $track->artists }}</b></p>
        <p>Title: <b>{{ $track->name }}</b></p>
        @if(count($track->remixers) > 0)
            <p>Remixer: <b>{{ implode(', ', $track->remixers) }}</b></p>
        @endif
        <p>Remix: <b>{{ $track->mix_name ?? 'Original Mix' }}</b></p>
        <p>Duration: <b>{{ $track->length }}</b></p>
        <p>Written by: <b>{{ $track->composer ?? $track->artists }}</b></p>
        <p>Mastering: <b>CTS studio</b></p>
        <p>Cat. number: <b>{{ $release->release_number }}</b></p>
        <p>ISRC: <b>{{ $track->isrc }}</b></p>
        <p>Published by <b>Atal Music</b></p>
        <p>Territory: <b>World excluding Korea</b></p>
        <p>Booking: <a href="mailto:info@cts-studio.com">info@cts-studio.com</a></p>
        <p>&copy; 2010 - {{ date('Y') }} CTS records</p>
        <p>
            <a href="https://cts-studio.com">www.cts-studio.com</a><br>
            <a href="{{ route('home') }}">www.cts-label.com</a>
        </p>
    </div>

</div>

<style>
    .wrapper{
        font-family: Arial, sans-serif;
        font-style: normal;
        margin-left: 100px;
        margin-top: 40px;
    }
    p{
        font-size: 16px;
    }
    p.fs-18{
        font-size: 18px;
    }
    .info{
        margin-top: 60px;
        padding-left: 60px;
    }
    img{
        width: 100%;
    }
    .mt-0{
        margin-top: 0;
    }
</style>
