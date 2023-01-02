@extends('layout.layout')

@section('title', 'Feedback to '. $feedback->feedback_title)

@section('scripts')
    <script src="/js/wavesurfer.min.js"></script>
@endsection

@section('content')

    <div class="container pt-5 pb-3 feedback">
        <div class="row">
            <div class="col-12 col-sm-auto cover text-center">
                @if($feedback->release)
                    <a href="{{ route('release', $feedback->release->id) }}" target="_blank" class="d-block">
                        <img src="/images/releases/{{ $feedback->release->image }}" alt="{{ $feedback->release->title }}">
                    </a>
                @else
                    <img src="/images/feedback/{{ $feedback->image }}" alt="{{ $feedback->feedback_title }}">
                @endif
            </div>
            <div class="col-12 col-sm">
                <div class="lang-switch mb-3 mt-3 mt-sm-0 justify-content-center justify-content-sm-end">
                    <div class="btn-group">
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en'])
                           data-lang="en" href="{{ route('feedback', $feedback->slug) }}">
                            @lang('shared.en')
                        </a>
                        <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ua' || !isset($_COOKIE['lang'])])
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
                        <h6 class="fw-bold">@lang('feedback.also_available'):</h6>
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
                <h5 class="text-center fw-bold text-light mb-3">@lang('feedback.feedback_form')</h5>
                <div class="d-flex m-auto flex-column form-group user-info">
                    <input type="text" class="form-control form-dark mb-2" id="name" name="name" required placeholder="@lang('feedback.your_name')">
                    <input type="email" class="form-control form-dark" id="email" name="email" required placeholder="@lang('feedback.your_email')">
                </div>
            </div>
            <hr class="w-75 m-auto my-3">

            <!-- ----------- Tracks ------------- -->
            @foreach($feedback->tracks as $key => $track)

                <div class="track py-3" data-id="{{ $key }}">
                    <div class="info row align-items-center">
                        <div class="title col-12 col-md flex-grow-1">{{ $track['title'] }}</div>
                        <div class="col-12 col-md-auto d-flex align-items-center flex-nowrap justify-content-between">
                            <div class="time text-nowrap">
                                <span class="current-time"></span>
                                <span class="time-break"></span>
                                <span class="duration"></span>
                            </div>
                            <div class="volume-bar ms-3">
                                <div class="volume-bar-value"></div>
                            </div>
                        </div>
                    </div>
                    <div class="bar d-flex align-items-center">
                        <button type="button" class="play-pause me-3"><i class="fa-solid fa-play"></i></button>
                        <div id="waveform_{{ $key }}" class="waveform flex-grow-1"></div>
                    </div>
                    <div class="rate_stars py-3">
                        <input type="number" class="star-rating" name="rates[{{ $track['title'] }}]" value=0 required>
                    </div>
                </div>
            @endforeach

            @if(count($feedback->tracks) > 1)
                <!-- ----------- Best track ------------- -->
                <div class="best_track text-light mb-5">
                    <h6 class="fw-bold">@lang('feedback.best_track'):</h6>
                    @foreach($feedback->tracks as $key => $track)
                        <div class="form-check">
                            <input type="radio" name="best_track" id="best_{{ $key }}" value="{{ $track['title'] }}" class="form-check-input" required>
                            <label for="best_{{ $key }}" class="form-check-label">{{ $track['title'] }}</label>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- ----------- Comment ------------- -->
            <div class="comment text-light mb-5">
                <h6 class="fw-bold">@lang('feedback.comment'):</h6>
                <textarea name="comment" class="form-control form-dark" rows="3" required></textarea>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-check me-2"></i>@lang('feedback.send')</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            let players = [];
            @foreach($feedback->tracks as $key => $track)

            let wavesurfer_{{ $key }} = WaveSurfer.create({
                container: '#waveform_{{ $key }}',
                normalize: true,
                barHeight: 1.3,
                height: 70,
                waveColor: '#5b450d',
                progressColor: '#e9a222',
                cursorWidth: 1
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
