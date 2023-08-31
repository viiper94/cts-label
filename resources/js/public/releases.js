// Releases
import {ReleasePlayer} from "../release_player";

$(document).ready(function(){

    $('.release-content-wrapper').readmore({
        collapsedHeight: 932,
        moreLink: '<button class="btn btn-sm btn-outline mt-1 border-0">...</button>',
        lessLink: '<button class="btn btn-sm btn-outline mt-1 border-0"><i class="fa-solid fa-caret-up me-2"></i>Hide</button>',
        heightMargin: 30
    });

    $('button.sharer').click(function(){
        let title = $('.release-title').html();
        let img = $('.release-image').attr('src');
        let social = $(this).data('social');
        let url = '';
        switch(social){
            case 'fb' :
                url = 'https://www.facebook.com/sharer.php?u='+window.location.href+'&picture=https://cts-label.com'+img;
                break;
            case 'tw' :
                url = 'https://twitter.com/intent/tweet?text=@CTS_RECORDS+'+title+'%0A&url='+window.location.href+'&hashtags=CTS';
                break;
            case 'mail' :
                url = 'mailto:?Subject='+title+'&body='+window.location.href;
                break;
        }
        window.open(url,'share-dialog',"resizable=0,width=626,height=436,scrollbars=yes");
    });

    $('button[data-track-id]').click(function () {
        const button = $(this);
        const trackId = button.data('track-id');
        const releaseId = button.data('release-id');
        const isDifferentTrack = trackId !== $('.preview-player').data('track');

        if (isDifferentTrack) {
            if (window.player !== undefined) {
                var muted = window.player.player.getMuted();
                var volume = window.player.player.getVolume();
                window.player.player.pause();
            }

            $.ajax({
                url: `/releases/track/${trackId}/${releaseId}`,
                success: function (response) {
                    if (window.player !== undefined) {
                        window.player.stopPlayer();
                    }

                    $('main').append(response.html);

                    window.player = new ReleasePlayer({
                        waveform: response.wave,
                        url: response.url,
                        sampleStart: response.sampleStart,
                        length: response.length,
                        el: button,
                        id: trackId
                    });

                    if (muted) {
                        window.player.toggleMute();
                    }

                    window.player.player.setVolume(volume ?? 0.7);
                },
                error: function (xhr) {
                    console.log('error');
                }
            });
        } else {
            window.player.playPause();
        }
    });

});
