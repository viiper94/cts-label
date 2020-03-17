@extends('feedback.layout')

@section('content')

    <style>
        section{
            margin: 0 20px;
            text-align: center;
            padding-bottom: 20px;
            border-bottom: solid 1px black;
        }
        .main_content{
            padding-top: 20px;
            margin: 0 20px;
            width: auto;
            text-align: center;
            border-bottom: 1px solid black;
        }
        .main_content a{
            display: block;
            color: red;
            font-size: 11px;
            line-height: 1.7;
        }
        .archive{
            margin-top: 15px;
            margin-bottom: 15px;
        }
    </style>

    <section>
        <span style="font-size: 18px;">Thank You!<br>Now You can find download links below!</span>
    </section>
    <div class="main_content">
        @foreach($feedback->tracks as $track)
            <a href="/audio/feedback/{{ $feedback->slug }}/320/{{ $track[320] }}" target="_blank">{{ $track['title'] }}</a>
        @endforeach
        <a class="archive" href="/audio/feedback/{{ $feedback->slug }}/{{ $feedback->archive_name }}" target="_blank">Download whole release by one archive </a>
    </div>

@endsection
