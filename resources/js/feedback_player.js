import WaveSurfer from 'wavesurfer.js';

export class FeedbackPlayer {
    constructor(init) {
        this.url = init.url;
        this.peaks = init.peaks;
        this.trackIndex = init.trackIndex;
        this.feedbackId = init.feedbackId;
        this.trackId = init.trackId;
        this.savePeaksRoute = init.savePeaksRoute;

        this.player = WaveSurfer.create({
            container: `#waveform_${this.trackIndex}`,
            barHeight: 1.3,
            height: 70,
            waveColor: '#e9a222',
            progressColor: '#5b450d',
            cursorWidth: 1,
            normalize: true
        });

        this.player.load(this.url, this.peaks);
        this.player.on('audioprocess', () => {
            this.updateCurrentTime();
        });
        this.player.on('ready', () => {
            this.afterInit();
            this.attachEventHandlers();
            if (!this.peaks) {
                this.sendPeaks();
            }
        });
    }

    updateCurrentTime() {
        $(`.track[data-id=${this.trackIndex}] .current-time`)
            .text(this.convertDuration(this.player.getCurrentTime()));
    }

    afterInit() {
        this.player.setVolume(0.7);
        $(`.track[data-id=${this.trackIndex}] .bar`).css({
            'background-image': 'none'
        });
        $(`.track[data-id=${this.trackIndex}] .volume-bar-value`).css({
            width: `${this.player.getVolume() * 100}%`
        });
        $(`.track[data-id=${this.trackIndex}] .duration`).text(this.convertDuration(this.player.getDuration()));
    }

    attachEventHandlers() {
        $(`.track[data-id=${this.trackIndex}] .play-pause`).click(() => {
            this.playPause();
        });

        $(`.track[data-id=${this.trackIndex}] .volume-bar`).click((e) => {
            this.setVolume(e);
        });

        $(`.track[data-id=${this.trackIndex}] .mute`).click(() => {
            this.toggleMute();
        });
    }

    playPause() {
        if (!this.player.isPlaying()) {
            this.stopPlayers();
            this.player.play();
            $(`.track[data-id=${this.trackIndex}] .play-pause i`).removeClass('fa-play').addClass('fa-pause');
        } else {
            this.player.pause();
            $(`.track[data-id=${this.trackIndex}] .play-pause i`).removeClass('fa-pause').addClass('fa-play');
        }
    }

    stopPlayers() {
        // Assuming you have an array of players in the window object
        window.players.forEach((item) => {
            item.player.pause();
            $(`.play-pause i`).removeClass('fa-pause').addClass('fa-play');
        });
    }

    setVolume(e) {
        const clickedPositionPercent = this.getBarClickPercent(e);
        $(`.track .volume-bar-value`).css({
            width: `${clickedPositionPercent}%`
        });
        window.players.forEach((item) => {
            item.player.setVolume(clickedPositionPercent / 100);
        });
    }

    toggleMute() {
        const isMuted = this.player.getMuted();
        window.players.forEach((item) => {
            item.player.setMuted(!isMuted);
        });
        const muteIcon = $(`.track .mute i`);
        muteIcon.toggleClass('fa-volume-high fa-volume-xmark');
    }

    sendPeaks() {
        const exported = this.player.exportPeaks();
        const peaks = JSON.stringify(exported[0]);
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
    }

    getBarClickPercent(e) {
        let $el = $(`.track[data-id=${this.trackIndex}] .volume-bar`);
        return (e.pageX - $el.offset().left) / $el.width() * 100;
    }

    convertDuration(duration) {
        const minutes = Math.floor(duration / 60);
        const seconds = Math.floor(duration - minutes * 60);
        return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }
}
