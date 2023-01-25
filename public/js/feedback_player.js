class FeedbackPlayer{
    constructor(init){
        this.url = init.url;
        this.trackIndex = init.trackIndex;
        this.peaks = init.peaks;
        this.feedbackId = init.feedbackId;
        this.trackId = init.trackId;
        this.savePeaksRoute = init.savePeaksRoute;

        this.player = WaveSurfer.create(this.getPlayerParams());

        let parent = this;

        this.player.load(init.url, this.peaks);
        this.player.on('audioprocess', function(){
            $('.track[data-id='+parent.trackIndex+'] .current-time').text(parent.convertDuration(parent.player.getCurrentTime()));
        });
        this.player.on('ready', function(){

            parent.afterInit();

            $('.track[data-id='+parent.trackIndex+'] .play-pause').click(function(){
                parent.playPause(this);
            });

            $('.track[data-id='+parent.trackIndex+'] .volume-bar').click(function(e){
                parent.setVolume(e, this);
            });

            if(!parent.peaks){
                parent.sendPeaks();
            }

        });

    }

    getPlayerParams(){
        let params = {
            container: '#waveform_'+this.trackIndex,
            normalize: true,
            barHeight: 1.3,
            height: 70,
            waveColor: '#5b450d',
            progressColor: '#e9a222',
            cursorWidth: 1
        }
        if(this.peaks){
            params['backend'] = 'MediaElementWebAudio';
        }
        return params;
    }

    afterInit(){
        $('.track[data-id='+this.trackIndex+'] .bar').css({
            'background-image': 'none'
        });
        $('.track[data-id='+this.trackIndex+'] .volume-bar-value').css({
            width: (this.player.getVolume()*100) + '%'
        });
        $('.track[data-id='+this.trackIndex+'] .duration').text(this.convertDuration(this.player.getDuration()));
    }

    playPause(el){
        if(!this.player.isPlaying()){
            this.stopPlayers();
            this.player.play();
            $(el).find('i').removeClass('fa-play').addClass('fa-pause');
        }else{
            this.player.pause();
            $(el).find('i').removeClass('fa-pause').addClass('fa-play');
        }
    }

    stopPlayers(){
        $.each(window.players, function(index, item){
            item.player.pause();
            $('.play-pause i').removeClass('fa-pause').addClass('fa-play');
        });
    }

    setVolume(e, el){
        let clickedPositionPercent = this.getBarClickPercent(e, el);
        $('.track .volume-bar-value').css({
            width: clickedPositionPercent + '%'
        });
        $.each(window.players, function(index, item){
            item.player.setVolume(clickedPositionPercent/100);
        });
        return true;
    }

    sendPeaks(){
        let parent = this;
        parent.player.exportPCM(1024, 10000, true).then(function(response){
            $.ajax({
                url: parent.savePeaksRoute,
                type : 'POST',
                cache: false,
                dataType : 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    track: parent.trackId,
                    peaks: JSON.stringify(response)
                }
            });
        });
    }

    getBarClickPercent(e, el){
        let clickedPositionPx = e.pageX - $(el).offset().left;
        let seekBarWidth = $(el).width();
        return clickedPositionPx/seekBarWidth *100;
    }

    convertDuration(duration){
        let dec = duration / 60;
        let min = parseInt(dec);
        if (min.toString().length === 1) min = '0' + min;
        let sec = Math.round((dec - min)*60);
        if (sec.toString().length === 1) sec = '0' + sec;
        return min + ':' + sec;
    }

}
