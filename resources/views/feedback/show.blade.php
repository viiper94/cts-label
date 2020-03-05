@extends('feedback.layout')

@section('content')

{{--    @if($errors->any())--}}
{{--        @dump($errors)--}}
{{--    @endif--}}
    <section>
        <div class="cover">
            <a href="{{ route('release', $release->id) }}" target="_blank">
                <img src="/images/releases/{{ $release->image }}" alt="{{ $release->title }}" style="max-width: 250px;">
            </a>
        </div>
        <div class="header_text_en">
            <span>Please let us know what you think by filling out this feedback form! After filling out our feedback
                form and sending your reaction by pushing "Send Feedback" button, you will get download links on new page.</span>
        </div>
        <div class="header_text_ru">
            <span>Пожалуйста оцените треки и оставьте свой коментарий в нижеприведенной форме! После заполнения формы и
                отправки Вашей рецензии, нажатием кнопки "Send Feedback", download линки будут доступны на следующей странице.</span>
        </div>
        <div class="also_avaliable">
            <span>Also avaliable:</span>
            @foreach($release->feedback->related as $track)
                <a href="{{ route('feedback', $track->release_id) }}" target="_blank">{{ $track->feedback_title }}</a>
            @endforeach
        </div>
    </section>
    <div class="main_content">
        <form class="form-horizontal" id="feedback-form" method="POST">
            @csrf
            <div class="info_inputs">
                <span>Feedback Form</span>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Your Name">
                <input type="email" class="form-control" id="email" name="email" required placeholder="Your E-mail">
            </div>

            <!-- ----------- Tracks ------------- -->
            @foreach($release->feedback->tracks as $key => $track)

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

            @if(count($release->feedback->tracks) > 1)
            <!-- ----------- Best track ------------- -->
            <div class="best_track">
                <span>Best Track/Remix:</span>
                @foreach($release->feedback->tracks as $track)
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
        let players = [];
        @foreach($release->feedback->tracks as $key => $track)

            let wavesurfer_{{ $key }} = WaveSurfer.create({
                container: '#waveform_{{ $key }}',
                barHeight: 1.3,
                height: 90,
                waveColor: '#339999',
                progressColor: '#339999',
                cursorWidth: 0,
                /*plugins: [
                    WaveSurfer.cursor.create({
                        showTime: true,
                        opacity: 1,
                        customShowTimeStyle: {
                            'background-color': '#000',
                            color: '#fff',
                            padding: '2px',
                            'font-size': '10px'
                        }
                    })
                ]*/
            });
            players.push(wavesurfer_{{ $key }});
            wavesurfer_{{ $key }}.load('/audio/feedback/{{ $release->id }}/320/{{ $track[320] }}');
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

    </script>

@endsection
