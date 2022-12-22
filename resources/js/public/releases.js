// Releases

$(document).ready(function(){

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
        console.log(url);
        window.open(url,'share-dialog',"resizable=0,width=626,height=436,scrollbars=yes");
    });

});
