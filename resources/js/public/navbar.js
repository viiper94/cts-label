// Navbar
$(document).ready(function(){

    $('#main_nav').scrollToFixed({
        fixed : function(){
            $('#navbar').addClass('menu-fixed');
        },
        postFixed : function() {
            $('#navbar').removeClass('menu-fixed');
        }
    });

});
