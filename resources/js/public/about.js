// About
$(document).ready(function(){

    let hash = window.location.hash;

    if ($(hash + '-menu').length > 0) {
        $('#about-menu').removeClass('active');
        $(hash + '-menu').addClass('active');
    }

    $('#contacts-menu, #demo-menu').on('click',function(){
        $('#about-menu').removeClass('active');
        $('#contacts-menu').removeClass('active');
        $('#demo-menu').removeClass('active');
        $(this).addClass('active');
        let target = $( $(this).attr('href') );
        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top + 60
            }, 300);
        }
    })

});
