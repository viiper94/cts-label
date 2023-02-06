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
        this.player.exportPCM(1024, 10000, true).then(pcmData => {
            const peaks = JSON.stringify(pcmData);
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const savePeaksRoute = this.savePeaksRoute;
            const trackId = this.trackId;

            $.ajax({
                url: savePeaksRoute,
                type: 'POST',
                cache: false,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: { track: trackId, peaks }
            });
        });
    }

    getBarClickPercent(e, el){
        return (e.pageX - $(el).offset().left) / $(el).width() * 100;
    }

    convertDuration(duration){
        let minutes = Math.floor(duration / 60);
        let seconds = Math.round(duration - minutes * 60);
        minutes = (minutes < 10) ? `0${minutes}` : minutes;
        seconds = (seconds < 10) ? `0${seconds}` : seconds;
        return `${minutes}:${seconds}`;
    }

}
