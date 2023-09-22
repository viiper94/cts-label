import WaveSurfer from 'wavesurfer.js';

export class ReleasePlayer {
    constructor(data) {
        this.id = data.id;
        this.waveform = data.waveform;
        this.sampleStart = data.sampleStart;
        this.length = data.length;
        this.url = data.url;
        this.el = data.el;
        this.volume = data.volume;
        this.muted = data.muted;

        this.player = WaveSurfer.create({
            container: '#waveform',
            height: 70,
            waveColor: 'rgba(255,206,0,0)',
            progressColor: '#eee',
            peaks: [0, 0],
            cursorWidth: 1,
            url: this.url
        });

        this.player.on('timeupdate', () => {
            this.updateTime();
        });

        this.player.on('finish', () => {
            this.stopPlayer();
        });

        this.player.on('ready', () => {
            this.initializeUI();
            this.playPause();
        });
    }

    updateTime() {
        const currentTime = this.player.getCurrentTime();
        $('.preview-player .current').text(this.convertDuration(currentTime, this.sampleStart));
        $('.preview-player .player-progress').css('right', this.getProgressBarRight() + '%');
    }

    initializeUI() {
        const volumeBar = $('.preview-player .volume-bar');
        const playPauseButton = $('.preview-player .play-pause');
        const closeButton = $('.preview-player .close');
        const muteButton = $('.preview-player .mute');

        $('.preview-player .volume-bar-value').css({
            width: (this.player.getVolume() * 100) + '%'
        });

        $('.preview-player .current').text(this.convertDuration(this.getStartTime()));

        volumeBar.click((e) => {
            this.setVolume(e, volumeBar);
        });

        playPauseButton.click(() => {
            this.playPause();
        });

        closeButton.click(() => {
            this.stopPlayer();
        });

        muteButton.click(() => {
            this.toggleMute();
        });

        $('.preview-player').show();
    }

    playPause() {
        if (!this.player.isPlaying()) {
            this.player.play();
        } else {
            this.player.pause();
        }
        this.togglePlayPauseIcons();
    }

    togglePlayPauseIcons() {
        const mainPlayPauseIcon = $(`.preview-player .play-pause i`);
        mainPlayPauseIcon.toggleClass('fa-play fa-pause');
        this.el.find('i').toggleClass('fa-play fa-pause');
    }

    stopPlayer() {
        this.player.pause();
        this.player.destroy();
        this.togglePlayPauseIcons();
        $('.preview-player').remove();
    }

    setVolume(e, el) {
        const clickedPositionPercent = this.getBarClickPercent(e, el);
        $('.preview-player .volume-bar-value').css({
            width: clickedPositionPercent + '%'
        });
        this.player.setVolume(clickedPositionPercent / 100);
    }

    toggleMute() {
        const isMuted = this.player.getMuted();
        this.player.setMuted(!isMuted);
        const muteIcon = $('.preview-player .mute i');
        muteIcon.toggleClass('fa-volume-high fa-volume-xmark');
    }

    getBarClickPercent(e, el) {
        return (e.pageX - $(el).offset().left) / $(el).width() * 100;
    }

    convertDuration(duration, offset = 0) {
        duration += offset / 1000;
        const minutes = Math.floor(duration / 60);
        const seconds = Math.floor(duration - minutes * 60);
        return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    getStartTime() {
        return this.convertDuration(this.sampleStart);
    }

    getProgressBarRight() {
        return 100 - ((parseInt(this.sampleStart) + this.player.getCurrentTime() * 1000) / this.length) * 100;
    }

    destroy() {
        this.player.destroy();
    }
}
