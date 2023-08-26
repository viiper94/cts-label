import WaveSurfer from 'wavesurfer.js'

export class ReleasePlayer{

    constructor(data){
        this.id = data.id;
        this.waveform = data.waveform;
        this.sampleStart = data.sampleStart;
        this.length = data.length;
        this.url = data.url;
        this.el = data.el;

        this.player = WaveSurfer.create({
            container: '#waveform',
            height: 70,
            waveColor: 'rgba(255,206,0,0)',
            progressColor: '#2abea8',
            peaks: [0,0],
            cursorWidth: 1,
            url: this.url
        });

        let parent = this;

        this.player.on('timeupdate', function(){
            $('.preview-player .current').text(parent.convertDuration(parent.player.getCurrentTime(), parent.sampleStart));
            $('.preview-player .player-progress').css('right', parent.getProgressBarRight()+'%');
        });

        this.player.on('finish', function(){
            parent.player.stop();
            $(parent.el).find('i').removeClass('fa-pause').addClass('fa-play');
            $($('.preview-player .play-pause')).find('i').removeClass('fa-pause').addClass('fa-play');
        });

        this.player.on('ready', function(){

            parent.player.setVolume(0.7);
            $('.preview-player .volume-bar-value').css({
                width: (parent.player.getVolume()*100) + '%'
            });

            $('.preview-player .current').text(parent.convertDuration(parent.getStartTime()));

            $('.preview-player .volume-bar').click(function(e){
                parent.setVolume(e, this);
            });

            $('.preview-player .play-pause').click(function(){
                parent.playPause();
            });

            $('.preview-player .close').click(function(){
                parent.stopPlayer();
            });

            $('.preview-player .mute').click(function(){
                parent.mutePlayer();
            });

            $('.preview-player').show();

            parent.playPause();

        });

    }

    playPause(){
        if(!this.player.isPlaying()){
            // this.stopPlayers();
            this.player.play();
            $(this.el).find('i').removeClass('fa-play').addClass('fa-pause');
            $('.preview-player .play-pause').find('i').removeClass('fa-play').addClass('fa-pause');
        }else{
            this.player.pause();
            $(this.el).find('i').removeClass('fa-pause').addClass('fa-play');
            $($('.preview-player .play-pause')).find('i').removeClass('fa-pause').addClass('fa-play');
        }
    }

    stopPlayer(){
        this.player.pause();
        this.player.destroy();
        $(this.el).find('i').removeClass('fa-pause').addClass('fa-play');
        $('.preview-player').remove();
    }

    setVolume(e, el){
        let clickedPositionPercent = this.getBarClickPercent(e, el);
        $('.preview-player .volume-bar-value').css({
            width: clickedPositionPercent + '%'
        });
        this.player.setVolume(clickedPositionPercent/100);
        return true;
    }

    mutePlayer(){
        if(this.player.getMuted()){
            this.player.setMuted(false);
            $($('.preview-player .mute')).find('i').removeClass('fa-volume-xmark').addClass('fa-volume-high');
        }else{
            this.player.setMuted(true);
            $($('.preview-player .mute')).find('i').removeClass('fa-volume-high').addClass('fa-volume-xmark');
        }
    }

    getBarClickPercent(e, el){
        return (e.pageX - $(el).offset().left) / $(el).width() * 100;
    }

    convertDuration(duration, offset = 0){
        duration += offset / 1000;
        let minutes = Math.floor(duration / 60);
        let seconds = Math.round(duration - minutes * 60);
        minutes = (minutes < 10) ? `0${minutes}` : minutes;
        seconds = (seconds < 10) ? `0${seconds}` : seconds;
        return `${minutes}:${seconds}`;
    }

    getStartTime(){
        return this.convertDuration(this.sampleStart)
    }

    getProgressBarRight(){
        return 100 - ((parseInt(this.sampleStart) + this.player.getCurrentTime()*1000) / this.length) * 100;
    }

    destroy(){
        this.player.destroy()
        return true;
    }

}
