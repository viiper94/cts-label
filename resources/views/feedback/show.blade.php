@extends('layout.layout')

@section('content')

    <div class="container py-5 feedback">
        <div class="row">
            <div class="col-12 col-sm-auto cover">
                @if($feedback->release)
                    <a href="{{ route('release', $feedback->release->id) }}" target="_blank">
                        <img src="/images/releases/{{ $feedback->release->image }}" alt="{{ $feedback->release->title }}">
                    </a>
                @else
                    <img src="/images/feedback/{{ $feedback->image }}" alt="{{ $feedback->feedback_title }}">
                @endif
            </div>
            <div class="col-12 col-sm">
                <div class="lang-switch mb-3">
                    <div class="btn-group">
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en' || !isset($_COOKIE['lang'])])
                           data-lang="en" href="{{ route('feedback', $feedback->slug) }}">
                            @lang('shared.en')
                        </a>
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ua'])
                           data-lang="ua" href="{{ route('feedback', $feedback->slug) }}">
                            @lang('shared.ua')
                        </a>
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ru'])
                           data-lang="ru" href="{{ route('feedback', $feedback->slug) }}">
                            @lang('shared.ru')
                        </a>
                    </div>
                </div>
                <p class="header_text py-3">@lang('feedback.header_text')</p>
                <hr>
                @if(count($feedback->related) > 0)
                    <div class="also_available py-3">
                        <h6 class="fw-bold">Also available:</h6>
                        <ul class="">
                            @foreach($feedback->related as $track)
                                <li><a href="{{ route('feedback', $track->slug) }}" target="_blank">{{ $track->feedback_title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <form id="feedback-form" class="py-3" method="post">
            @csrf
            <div class="row">
                <h5 class="text-center fw-bold">Feedback Form</h5>
                <div class="d-flex w-25 m-auto flex-column form-group">
                    <input type="text" class="form-control form-dark mb-2" id="name" name="name" required placeholder="Your Name">
                    <input type="email" class="form-control form-dark" id="email" name="email" required placeholder="Your E-mail">
                </div>
            </div>
            <hr class="w-75 m-auto my-3">

            <!-- ----------- Tracks ------------- -->
            @foreach($feedback->tracks as $key => $track)

                <div class="track" data-id="{{ $key }}">
                    <div class="info">
                        <div class="title">{{ $track['title'] }}</div>
                        <div class="time">
                            <div class="current-time"></div>
                            <div class="time-break"></div>
                            <div class="duration"></div>
                        </div>
                        <div class="volume-bar">
                            <div class="volume-bar-value"></div>
                        </div>
                    </div>
                    <div class="bar" style="background-image: url(/assets/css/loading.gif);">
                        <a class="play-pause"><i class="fas fa-play"></i></a>
                        <div id="waveform_{{ $key }}" class="waveform"></div>
                    </div>
                    <div class="rate_radio">
                        @for($i = 1; $i <= 10; $i++)
                            <input type="radio" id="{{ $key.'_'.$i }}" name="rates[{{ $track['title'] }}]" value="{{ $i }}" required>
                        @endfor
                    </div>
                    <div class="rate_labels">
                        @for($i = 1; $i <= 10; $i++)
                            <label for="{{ $key.'_'.$i }}">{{ $i }}</label>
                        @endfor
                    </div>
                </div>
            @endforeach

            @if(count($feedback->tracks) > 1)
                <!-- ----------- Best track ------------- -->
                <div class="best_track">
                    <span>Best Track/Remix:</span>
                    @foreach($feedback->tracks as $track)
                        <label>
                            <input type="radio" name="best_track" value="{{ $track['title'] }}" required>&nbsp
                            {{ $track['title'] }}
                        </label>
                    @endforeach
                </div>
            @endif

            <!-- ----------- Comment ------------- -->
            <div class="comment">
                <span>Comment:</span>
                <textarea name="comment" class="form-control" cols="59" rows="7" required></textarea>
            </div>
            <input class="submit_button btn btn-primary" type="submit" name="send_feedback" value="Send Feedback">
        </form>
    </div>

    <script>
        $(document).ready(function(){
            let players = [];
            @foreach($feedback->tracks as $key => $track)

            let wavesurfer_{{ $key }} = WaveSurfer.create({
                container: '#waveform_{{ $key }}',
                barHeight: 1.3,
                height: 90,
                waveColor: '#339999',
                progressColor: '#339999',
                cursorWidth: 0
            });
            players.push(wavesurfer_{{ $key }});
            wavesurfer_{{ $key }}.load('/audio/feedback/{{ $feedback->slug }}/320/{!! $track[320] !!}');
            wavesurfer_{{ $key }}.on('ready', function(){

                $('.track[data-id={{ $key }}] .bar').css({
                    'background-image': 'none'
                });
                $('.track[data-id={{ $key }}] .volume-bar-value').css({
                    width: (wavesurfer_{{ $key }}.getVolume()*100) + '%'
                });
                $('.track[data-id={{ $key }}] .current-time').text('00:00');
                $('.track[data-id={{ $key }}] .time-break').text('/');
                $('.track[data-id={{ $key }}] .duration').text(convertDuration(wavesurfer_{{ $key }}.getDuration()));


                $('.track[data-id={{ $key }}] .play-pause').click(function(){
                    if(!wavesurfer_{{ $key }}.isPlaying()){
                        $.each(players, function(index, player){
                            if(index + 1 !== {{ $key }}){
                                player.pause();
                                $('.play-pause i').removeClass('fa-pause').addClass('fa-play');
                            }
                        });
                        wavesurfer_{{ $key }}.play();
                        $(this).find('i').removeClass('fa-play').addClass('fa-pause');
                    }else{
                        wavesurfer_{{ $key }}.pause();
                        $(this).find('i').removeClass('fa-pause').addClass('fa-play');
                    }
                });
                $('.track[data-id={{ $key }}] .volume-bar').click(function(e){
                    var clickedPositionPercent = getBarClickPercent(e, this);
                    $('.track .volume-bar-value').css({
                        width: clickedPositionPercent + '%'
                    });
                    $.each(players, function(index, player){
                        player.setVolume(clickedPositionPercent/100);
                    });
                });
            });
            wavesurfer_{{ $key }}.on('audioprocess', function(){
                $('.track[data-id={{ $key }}] .current-time').text(convertDuration(wavesurfer_{{ $key }}.getCurrentTime()));
            });
            @endforeach

            function convertDuration(duration){
                var dec = duration / 60;
                var min = parseInt(dec);
                if (min.toString().length === 1) min = '0' + min;
                var sec = Math.round((dec - min)*60);
                if (sec.toString().length === 1) sec = '0' + sec;
                return min + ':' + sec;
            }

            function getBarClickPercent(e, el){
                var clickedPositionPx = e.pageX - $(el).offset().left;
                var seekBarWidth = $(el).width();
                return clickedPositionPx/seekBarWidth *100;
            }
        });


    </script>

@endsection
